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

namespace ApiPlatform\SchemaGenerator\AttributeGenerator;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Generates API Platform core attributes.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @see    https://github.com/api-platform/core
 */
final class ApiPlatformCoreAttributeGenerator extends AbstractAttributeGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAttributes(Class_ $class): array
    {
        if ($class->isAbstract) {
            return [];
        }

        $arguments = [];
        if ($class->name() !== $localName = $class->resourceLocalName()) {
            $arguments['shortName'] = $localName;
        }
        $arguments['iri'] = $class->resourceUri();
        if ($class->security) {
            $arguments['security'] = $class->security;
        }

        if ($class->operations) {
            $operations = $this->validateClassOperations($class->operations);
            foreach ($operations as $operationTarget => $targetOperations) {
                $targetArguments = [];
                foreach ($targetOperations as $method => $methodConfig) {
                    $methodArguments = [];
                    foreach ($methodConfig as $key => $value) {
                        $methodArguments[$key] = $value;
                    }
                    $targetArguments[$method] = $methodArguments;
                }
                $arguments[sprintf('%sOperations', $operationTarget)] = $targetArguments;
            }
        }

        return [new Attribute('ApiResource', $arguments)];
    }

    /**
     * Verifies that the operations config is valid.
     *
     * @template T of array
     *
     * @param T $operations
     *
     * @return T
     */
    private function validateClassOperations(array $operations): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['item' => [], 'collection' => []]);
        $resolver->setAllowedTypes('item', 'array');
        $resolver->setAllowedTypes('collection', 'array');

        return $resolver->resolve($operations);
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        $arguments['iri'] = $property->resourceUri();

        if ($property->security) {
            $arguments['security'] = $property->security;
        }

        return $property->isCustom ? [] : [new Attribute('ApiProperty', $arguments)];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return !$class->isEnum() ? [new Use_(ApiResource::class), new Use_(ApiProperty::class)] : [];
    }
}
