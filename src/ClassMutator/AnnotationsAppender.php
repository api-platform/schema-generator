<?php

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\AnnotationGenerator\AnnotationGeneratorInterface;
use ApiPlatform\SchemaGenerator\Model\Class_;

final class AnnotationsAppender implements ClassMutatorInterface
{
    /** @var AnnotationGeneratorInterface[] */
    private array $annotationGenerators;
    /** @var Class_[] */
    private array $classes;
    private array $typesToGenerate;

    /**
     * @param array $classes
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    public function __construct(array $classes, array $annotationGenerators, array $typesToGenerate)
    {
        $this->annotationGenerators = $annotationGenerators;
        $this->classes = $classes;
        $this->typesToGenerate = $typesToGenerate;
    }

    public function __invoke(Class_ $class): Class_
    {
        $class = $this->generateClassUses($class);
        $class = $this->generateClassAnnotations($class);
        if (false === isset($this->typesToGenerate[$class->name()])) {
            $class = $this->generateInterfaceAnnotations($class);
        }

        $class = $this->generateConstantAnnotations($class);
        $class = $this->generatePropertiesAnnotations($class);

        return $class;
    }

    /**
     * @param AnnotationGeneratorInterface[] $this->annotationGenerators
     */
    private function generateClassUses(Class_ $class): Class_
    {
        $interfaceNamespace = isset($this->classes[$class->name()]) ? $this->classes[$class->name()]->interfaceNamespace() : null;
        if ($interfaceNamespace && $class->interfaceNamespace() !== $class->namespace()) {
            $class->addUse(sprintf('%s\\%s', $class->interfaceNamespace(), $class->interfaceName()));
        }

        foreach ($class->properties() as $property) {
            if (isset($this->classes[$property->rangeName]) && $this->classes[$property->rangeName]->interfaceName()) {
                $class->addUse(sprintf(
                    '%s\\%s',
                    $this->classes[$property->rangeName]->interfaceNamespace(),
                    $this->classes[$property->rangeName]->interfaceName()
                ));
            }
        }

        foreach ($this->annotationGenerators as $generator) {
            foreach ($generator->generateUses($class) as $use) {
                $class->addUse($use);
            };
        }


        return $class;
    }

    private function generateClassAnnotations(Class_ $class): Class_
    {
        foreach ($this->annotationGenerators as $generator) {
            foreach ($generator->generateClassAnnotations($class) as $annotation) {
                $class->addAnnotation($annotation);
            };
        }

        return $class;
    }

    /**
     * @param AnnotationGeneratorInterface[] $this->annotationGenerators
     */
    private function generateConstantAnnotations(Class_ $class): Class_
    {
        foreach ($class->constants() as $name => &$constant) {
            foreach ($this->annotationGenerators as $generator) {
                foreach ($generator->generateConstantAnnotations($constant) as $constantAnnotation) {
                    $constant->addAnnotation($constantAnnotation);
                }
            }
        }

        return $class;
    }


    private function generateInterfaceAnnotations(Class_ $class): Class_
    {
        foreach ($this->annotationGenerators as $generator) {
            foreach($generator->generateInterfaceAnnotations($class) as $interfaceAnnotation) {
                $class->addInterfaceAnnotation($interfaceAnnotation);
            }
        }

        return $class;
    }

    private function generatePropertiesAnnotations(Class_ $class): Class_
    {
        foreach ($class->properties() as $name => &$property) {
            foreach ($this->annotationGenerators as $annotationGenerator) {
                foreach ($annotationGenerator->generatePropertyAnnotations($property, $class->name()) as $propertyAnnotation) {
                    $property->addAnnotation($propertyAnnotation);
                }

                foreach ($annotationGenerator->generateGetterAnnotations($property) as $getterAnnotation) {
                    $property->addGetterAnnotation($getterAnnotation);
                }

                if ($property->isArray) {
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

        return $class;
    }
}
