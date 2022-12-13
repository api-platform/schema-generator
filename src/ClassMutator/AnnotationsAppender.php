<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\AnnotationGenerator\AnnotationGeneratorInterface;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Use_;
use EasyRdf\Resource as RdfResource;

final class AnnotationsAppender implements ClassMutatorInterface
{
    /** @var Class_[] */
    private array $classes;
    /** @var AnnotationGeneratorInterface[] */
    private array $annotationGenerators;
    /** @var RdfResource[] */
    private array $typesToGenerate;

    /**
     * @param Class_[]                       $classes
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param RdfResource[]                  $typesToGenerate
     */
    public function __construct(array $classes, array $annotationGenerators, array $typesToGenerate)
    {
        $this->annotationGenerators = $annotationGenerators;
        $this->classes = $classes;
        $this->typesToGenerate = $typesToGenerate;
    }

    /**
     * @param array{} $context
     */
    public function __invoke(Class_ $class, array $context): void
    {
        $this->generateClassUses($class);
        $this->generateClassAnnotations($class);
        if (false === isset($this->typesToGenerate[$class->name()])) {
            $this->generateInterfaceAnnotations($class);
        }

        $this->generateConstantAnnotations($class);
        $this->generatePropertiesAnnotations($class);
    }

    private function generateClassUses(Class_ $class): void
    {
        $interfaceNamespace = isset($this->classes[$class->name()]) ? $this->classes[$class->name()]->interfaceNamespace() : null;
        if ($interfaceNamespace && $class->interfaceNamespace() !== $class->namespace) {
            $class->addUse(new Use_(sprintf('%s\\%s', $class->interfaceNamespace(), $class->interfaceName())));
        }

        foreach ($class->properties() as $property) {
            if ($property->reference && $property->reference->interfaceName()) {
                $class->addUse(new Use_(sprintf(
                    '%s\\%s',
                    $property->reference->interfaceNamespace(),
                    $property->reference->interfaceName()
                )));
            }
        }

        foreach ($this->annotationGenerators as $generator) {
            foreach ($generator->generateUses($class) as $use) {
                $class->addUse($use);
            }
        }
    }

    private function generateClassAnnotations(Class_ $class): void
    {
        foreach ($this->annotationGenerators as $generator) {
            foreach ($generator->generateClassAnnotations($class) as $annotation) {
                $class->addAnnotation($annotation);
            }
        }
    }

    private function generateConstantAnnotations(Class_ $class): void
    {
        foreach ($class->constants() as $constant) {
            foreach ($this->annotationGenerators as $generator) {
                foreach ($generator->generateConstantAnnotations($constant) as $constantAnnotation) {
                    $constant->addAnnotation($constantAnnotation);
                }
            }
        }
    }

    private function generateInterfaceAnnotations(Class_ $class): void
    {
        foreach ($this->annotationGenerators as $generator) {
            foreach ($generator->generateInterfaceAnnotations($class) as $interfaceAnnotation) {
                $class->addInterfaceAnnotation($interfaceAnnotation);
            }
        }
    }

    private function generatePropertiesAnnotations(Class_ $class): void
    {
        foreach ($class->properties() as $property) {
            foreach ($this->annotationGenerators as $annotationGenerator) {
                foreach ($annotationGenerator->generatePropertyAnnotations($property, $class->name()) as $propertyAnnotation) {
                    $property->addAnnotation($propertyAnnotation);
                }

                foreach ($annotationGenerator->generateGetterAnnotations($property) as $getterAnnotation) {
                    $property->addGetterAnnotation($getterAnnotation);
                }

                if ($property->isArray()) {
                    foreach ($annotationGenerator->generateAdderAnnotations($property) as $adderAnnotation) {
                        $property->addAdderAnnotation($adderAnnotation);
                    }

                    foreach ($annotationGenerator->generateRemoverAnnotations($property) as $removerAnnotation) {
                        $property->addRemoverAnnotation($removerAnnotation);
                    }
                } else {
                    foreach ($annotationGenerator->generateSetterAnnotations($property) as $setterAnnotation) {
                        $property->addSetterAnnotation($setterAnnotation);
                    }
                }
            }
        }
    }
}
