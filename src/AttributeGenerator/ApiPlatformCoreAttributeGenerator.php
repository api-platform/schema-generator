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
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
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
        if ($class->isAbstract()) {
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

        if ([] !== $class->operations()) {
            $operations = $this->validateClassOperations($class->operations());
            foreach ($operations as $operationTarget => $targetOperations) {
                $targetArguments = [];
                foreach ($targetOperations as $method => $methodConfig) {
                    $methodConfig = $this->validateClassOperationMethodConfig($methodConfig);
                    $methodArguments = [];
                    foreach ($methodConfig as $key => $value) {
                        $methodArguments[$key] = $value;
                    }
                    $targetArguments[$method] = $methodArguments;
                }
                $arguments[sprintf('%sOperations', $operationTarget)] = $targetArguments;
            }
        }

        return [['ApiResource' => $arguments]];
    }

    /**
     * Verifies that the operations config is valid.
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
     * Validates the individual method config for an item/collection operation attribute.
     */
    private function validateClassOperationMethodConfig(array $methodConfig): array
    {
        $resolver = new OptionsResolver();

        $resolver->setDefined(['method', 'route_name']);
        $resolver->setAllowedTypes('method', 'string');
        $resolver->setAllowedTypes('route_name', 'string');
        $resolver->setNormalizer(
            'route_name',
            function (Options $options, $value) {
                if (isset($options['method'])) {
                    throw new InvalidOptionsException('You must provide only \'method\' or \'route_name\', but not both');
                }

                return $value;
            }
        );

        return $resolver->resolve($methodConfig);
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

        return $property->isCustom ? [] : [['ApiProperty' => $arguments]];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return !$class->isEnum() ? [ApiResource::class, ApiProperty::class] : [];
    }
}
