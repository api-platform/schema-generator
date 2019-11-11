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
use ApiPlatform\SchemaGenerator\TypesGenerator;
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
    public function generateClassAnnotations(string $className): array
    {
        $class = $this->classes[$className];

        $resource = $class['resource'];

        $arguments = [sprintf('iri="%s"', $resource->getUri())];

        if (isset($class['operations'])) {
            $operations = $this->validateClassOperations((array) $class['operations']);
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
    public function generateFieldAnnotations(string $className, string $fieldName): array
    {
        return $this->classes[$className]['fields'][$fieldName]['isCustom'] ? [] : [
            sprintf(
                '@ApiProperty(iri="http://schema.org/%s")',
                $fieldName
            ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(string $className): array
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && TypesGenerator::SCHEMA_ORG_ENUMERATION === $subClassOf->getUri();

        return $typeIsEnum ? [] : [ApiResource::class, ApiProperty::class];
    }
}
