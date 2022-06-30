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
        $typeConfig = $this->config['types'][$class->name()] ?? null;
        $vocabConfig = null;
        if ($class instanceof SchemaClass) {
            $vocabConfig = $this->config['vocabularies'][$class->resource()->getGraph()->getUri()] ?? null;
        }

        $attributes = [];
        $configAttributes = array_merge($vocabConfig['attributes'] ?? [], $typeConfig['attributes'] ?? []);
        foreach ($configAttributes as $attributeName => $attributeArgs) {
            $attributes[] = new Attribute($attributeName, ($attributeArgs ?? []) + ['alwaysGenerate' => !isset($vocabConfig['attributes'][$attributeName]) || isset($typeConfig['attributes'][$attributeName])]);
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        $typeConfig = $this->config['types'][$className] ?? null;
        $propertyConfig = $typeConfig['properties'][$property->name()] ?? null;

        $attributes = [];
        foreach ($propertyConfig['attributes'] ?? [] as $attributeName => $attributeArgs) {
            $attributes[] = new Attribute($attributeName, $attributeArgs ?? []);
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
