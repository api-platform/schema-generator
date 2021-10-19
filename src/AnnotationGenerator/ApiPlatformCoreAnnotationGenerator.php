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

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Generates API Platform core annotations.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @see    https://github.com/api-platform/core
 */
final class ApiPlatformCoreAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(Class_ $class): array
    {
        if ($class->isAbstract()) {
            return [];
        }

        $arguments = [];
        if ($class->name() !== $localName = $class->resourceLocalName()) {
            $arguments[] = sprintf('shortName="%s"', $localName);
        }
        $arguments[] = sprintf('iri="%s"', $class->resourceUri());

        if ([] !== $class->operations()) {
            $operations = $this->validateClassOperations($class->operations());
            foreach ($operations as $operationTarget => $targetOperations) {
                $targetArguments = [];
                foreach ($targetOperations as $method => $methodConfig) {
                    $methodConfig = $this->validateClassOperationMethodConfig($methodConfig);
                    $methodArguments = [];
                    foreach ($methodConfig as $key => $value) {
                        $methodArguments[] = sprintf('"%s"="%s"', $key, $value);
                    }
                    $targetArguments[] = sprintf('"%s"={%s}', $method, implode(', ', $methodArguments));
                }
                $arguments[] = sprintf('%sOperations={%s}', $operationTarget, implode(', ', $targetArguments));
            }
        }

        return [sprintf('@ApiResource(%s)', implode(', ', $arguments))];
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
     * Validates the individual method config for an item/collection operation annotation.
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
    public function generatePropertyAnnotations(Property $property, string $className): array
    {
        return $property->isCustom ? [] : [
            sprintf(
                '@ApiProperty(iri="%s")',
                $property->resourceUri()
            ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return !$class->isEnum() ? [ApiResource::class, ApiProperty::class] : [];
    }
}
