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
    public function generateClassAttributes(Class_ $class): array
    {
        if ($class->hasChild || $class->isEnum()) {
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
                    // https://github.com/api-platform/schema-generator/issues/405
                    if (\array_key_exists('class', $methodConfig ?? [])) {
                        /** @var string $operationMetadataClass */
                        $operationMetadataClass = $methodConfig['class'];
                        unset($methodConfig['class']);
                    }

                    $arguments['operations'][] = new Literal(sprintf('new %s(...?:)',
                        $operationMetadataClass,
                    ), [$methodConfig ?? []]);
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

    public function generateUses(Class_ $class): array
    {
        if ($this->config['apiPlatformOldAttributes']) {
            // @phpstan-ignore-next-line
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
