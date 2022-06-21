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

use ApiPlatform\Core\Annotation\ApiProperty as OldApiProperty;
use ApiPlatform\Core\Annotation\ApiResource as OldApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;
use Nette\PhpGenerator\Literal;
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
        if ($class->isAbstract || $class->isEnum()) {
            return [];
        }

        $arguments = [];
        if ($class->name() !== $localName = $class->shortName()) {
            $arguments['shortName'] = $localName;
        }

        if ($class->rdfType()) {
            if ($this->config['apiPlatformOldAttributes']) {
                $arguments['iri'] = $class->rdfType();
            } else {
                $arguments['types'] = [$class->rdfType()];
            }
        }

        if ($class->operations) {
            if ($this->config['apiPlatformOldAttributes']) {
                $operations = $this->validateClassOperations($class->operations);
                foreach ($operations as $operationTarget => $targetOperations) {
                    $targetArguments = [];
                    foreach ($targetOperations ?? [] as $method => $methodConfig) {
                        $methodArguments = [];
                        if (!is_iterable($methodConfig)) {
                            continue;
                        }
                        foreach ($methodConfig as $key => $value) {
                            $methodArguments[$key] = $value;
                        }
                        $targetArguments[$method] = $methodArguments;
                    }
                    $arguments[sprintf('%sOperations', $operationTarget)] = $targetArguments;
                }
            } else {
                $arguments['operations'] = [];
                foreach ($class->operations as $operationMetadataClass => $methodConfig) {
                    $arguments['operations'][] = new Literal(sprintf('new %s(%s)',
                        $operationMetadataClass,
                        implode(', ', array_map(
                            fn ($k, $v) => sprintf('%s: %s', $k, (\is_string($v) ? sprintf("'%s'", addslashes($v)) : (\is_scalar($v) ? $v : ''))),
                            array_keys($methodConfig ?? []), array_values($methodConfig ?? [])
                        ))
                    ));
                }
            }
        }

        return [new Attribute('ApiResource', $arguments)];
    }

    /**
     * Verifies that the operations' config is valid.
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
        $arguments = [];

        if ($property->rdfType()) {
            if ($this->config['apiPlatformOldAttributes']) {
                $arguments['iri'] = $property->rdfType();
            } else {
                $arguments['types'] = [$property->rdfType()];
            }
        }

        return $property->isCustom ? [] : [new Attribute('ApiProperty', $arguments)];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        if ($this->config['apiPlatformOldAttributes']) {
            return [new Use_(OldApiResource::class), new Use_(OldApiProperty::class)];
        }

        return [
            new Use_(ApiResource::class),
            new Use_(ApiProperty::class),
            new Use_(Get::class),
            new Use_(Put::class),
            new Use_(Patch::class),
            new Use_(Delete::class),
            new Use_(GetCollection::class),
            new Use_(Post::class),
        ];
    }
}
