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

use ApiPlatform\SchemaGenerator\AttributeGenerator\AttributeGeneratorInterface;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Use_;

final class AttributeAppender implements ClassMutatorInterface
{
    /** @var Class_[] */
    private array $classes;
    /** @var AttributeGeneratorInterface[] */
    private array $attributeGenerators;

    /**
     * @param Class_[]                      $classes
     * @param AttributeGeneratorInterface[] $attributeGenerators
     */
    public function __construct(array $classes, array $attributeGenerators)
    {
        $this->attributeGenerators = $attributeGenerators;
        $this->classes = $classes;
    }

    /**
     * @param array{} $context
     */
    public function __invoke(Class_ $class, array $context): void
    {
        $this->generateClassUses($class);
        $this->generateClassAttributes($class);
        $this->generatePropertiesAttributes($class);
    }

    public function appendLate(Class_ $class): void
    {
        $this->generateLateClassAttributes($class);
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

        foreach ($this->attributeGenerators as $generator) {
            foreach ($generator->generateUses($class) as $use) {
                $class->addUse($use);
            }
        }
    }

    private function generateClassAttributes(Class_ $class): void
    {
        foreach ($this->attributeGenerators as $generator) {
            foreach ($generator->generateClassAttributes($class) as $attribute) {
                $class->addAttribute($attribute);
            }
        }
    }

    private function generatePropertiesAttributes(Class_ $class): void
    {
        foreach ($class->properties() as $property) {
            foreach ($this->attributeGenerators as $attributeGenerator) {
                foreach ($attributeGenerator->generatePropertyAttributes($property, $class->name()) as $propertyAttribute) {
                    $property->addAttribute($propertyAttribute);
                }
            }
        }
    }

    private function generateLateClassAttributes(Class_ $class): void
    {
        foreach ($this->attributeGenerators as $generator) {
            foreach ($generator->generateLateClassAttributes($class) as $attribute) {
                $class->addAttribute($attribute);
            }
        }
    }
}
