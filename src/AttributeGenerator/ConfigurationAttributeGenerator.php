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

use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;

final class ConfigurationAttributeGenerator extends AbstractAttributeGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAttributes(Class_ $class): array
    {
        $typeAttributes = $this->config['types'][$class->name()]['attributes'] ?? [[]];
        $vocabAttributes = [[]];
        if ($class instanceof SchemaClass) {
            $vocabAttributes = $this->config['vocabularies'][$class->resource()->getGraph()->getUri()]['attributes'] ?? [[]];
        }

        $getAttributesNames = fn (array $config) => $config === [[]]
            ? []
            : array_unique(array_map(fn (array $v) => array_keys($v)[0], $config));
        $typeAttributesNames = $getAttributesNames($typeAttributes);
        $vocabAttributesNames = $getAttributesNames($vocabAttributes);

        $getAttribute = fn (string $name, $args) => new Attribute(
            $name,
            (\is_array($args) ? $args : [$args]) + [
                'alwaysGenerate' => !\in_array($name, $vocabAttributesNames, true) ||
                    \in_array($name, $typeAttributesNames, true),
                'mergeable' => false,
            ]
        );

        $attributes = [];
        foreach ($vocabAttributes as $configAttributes) {
            foreach ($configAttributes ?? [] as $attributeName => $attributeArgs) {
                if (!\in_array($attributeName, $typeAttributesNames, true)) {
                    $attributes[] = $getAttribute($attributeName, $attributeArgs ?? []);
                }
            }
        }
        foreach ($typeAttributes as $configAttributes) {
            foreach ($configAttributes ?? [] as $attributeName => $attributeArgs) {
                $attributes[] = $getAttribute($attributeName, $attributeArgs ?? []);
            }
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        $typeConfig = $this->config['types'][$className] ?? null;
        $propertyAttributes = $typeConfig['properties'][$property->name()]['attributes'] ?? [[]];

        $attributes = [];
        foreach ($propertyAttributes as $configAttributes) {
            foreach ($configAttributes ?? [] as $attributeName => $attributeArgs) {
                $attributes[] = new Attribute(
                    $attributeName,
                    ($attributeArgs ?? []) + ['mergeable' => false]
                );
            }
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        $uses = [];
        foreach ($this->config['uses'] as $useName => $useArgs) {
            $uses[] = new Use_($useName, $useArgs['alias'] ?? null);
        }

        return $uses;
    }
}
