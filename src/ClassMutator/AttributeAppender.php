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

    public function __invoke(Class_ $class): Class_
    {
        $class = $this->generateClassUses($class);
        $class = $this->generateClassAttributes($class);
        $class = $this->generatePropertiesAttributes($class);

        return $class;
    }

    private function generateClassUses(Class_ $class): Class_
    {
        $interfaceNamespace = isset($this->classes[$class->name()]) ? $this->classes[$class->name()]->interfaceNamespace() : null;
        if ($interfaceNamespace && $class->interfaceNamespace() !== $class->namespace) {
            $class->addUse(new Use_(sprintf('%s\\%s', $class->interfaceNamespace(), $class->interfaceName())));
        }

        foreach ($class->properties() as $property) {
            if (isset($this->classes[$property->rangeName]) && $this->classes[$property->rangeName]->interfaceName()) {
                $class->addUse(new Use_(sprintf(
                    '%s\\%s',
                    $this->classes[$property->rangeName]->interfaceNamespace(),
                    $this->classes[$property->rangeName]->interfaceName()
                )));
            }
        }

        foreach ($this->attributeGenerators as $generator) {
            foreach ($generator->generateUses($class) as $use) {
                $class->addUse($use);
            }
        }

        return $class;
    }

    private function generateClassAttributes(Class_ $class): Class_
    {
        foreach ($this->attributeGenerators as $generator) {
            foreach ($generator->generateClassAttributes($class) as $attribute) {
                $class->addAttribute($attribute);
            }
        }

        return $class;
    }

    private function generatePropertiesAttributes(Class_ $class): Class_
    {
        foreach ($class->properties() as $property) {
            foreach ($this->attributeGenerators as $attributeGenerator) {
                foreach ($attributeGenerator->generatePropertyAttributes($property, $class->name()) as $propertyAttribute) {
                    $property->addAttribute($propertyAttribute);
                }
            }
        }

        return $class;
    }
}
