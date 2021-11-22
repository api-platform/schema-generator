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

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;

/**
 * Doctrine MongoDB attribute generator.
 *
 * @author Andrew Meshchanchuk <andrew.meshchanchuk@gmail.com>>
 */
final class DoctrineMongoDBAttributeGenerator extends AbstractAttributeGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAttributes(Class_ $class): array
    {
        if ($doctrineAttributes = isset($this->config['types'][$class->name()]) ? $this->config['types'][$class->name()]['doctrine']['attributes'] : false) {
            $attributes = [];
            foreach ($doctrineAttributes as $attributeName => $attributeArgs) {
                $attributes[] = new Attribute($attributeName, $attributeArgs);
            }

            return $attributes;
        }

        if ($class->isEnum()) {
            return [];
        }

        $attributes = [];
        if ($class->isAbstract) {
            if ($inheritanceAttributes = $this->config['doctrine']['inheritanceAttributes']) {
                $attributes = [];
                foreach ($inheritanceAttributes as $attributeName => $attributeArgs) {
                    $attributes[] = new Attribute($attributeName, $attributeArgs);
                }

                return $attributes;
            }

            $attributes[] = new Attribute('MongoDB\MappedSuperclass');
        } else {
            $attributes[] = new Attribute('MongoDB\Document');
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        if (null === $property->range) {
            return [];
        }

        if ($property->isId) {
            return $this->generateIdAttributes();
        }

        $type = null;
        if ($property->isEnum) {
            $type = $property->isArray ? 'simple_array' : 'string';
        } elseif ($property->isArray ?? false) {
            $type = 'collection';
        } elseif (null !== $phpType = $this->phpTypeConverter->getPhpType($property, $this->config, [])) {
            switch ($property->range->getUri()) {
                case 'http://www.w3.org/2001/XMLSchema#time':
                case 'https://schema.org/Time':
                    $type = 'time';
                    break;
                case 'http://www.w3.org/2001/XMLSchema#dateTime':
                case 'https://schema.org/DateTime':
                    $type = 'date';
                    break;
                default:
                    $type = $phpType;
                    switch ($phpType) {
                        case 'bool':
                            $type = 'boolean';
                            break;
                        case 'int':
                            $type = 'integer';
                            break;
                        case '\\'.\DateTimeInterface::class:
                            $type = 'date';
                            break;
                        case '\\'.\DateInterval::class:
                            $type = 'string';
                            break;
                    }
                    break;
            }
        }

        if (null !== $type) {
            return [new Attribute('MongoDB\Field', ['type' => $type])];
        }

        if ((CardinalitiesExtractor::CARDINALITY_0_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_0 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_1 === $property->cardinality) && $property->rangeName) {
            return [new Attribute('MongoDB\ReferenceOne', ['targetDocument' => $this->getRelationName($property->rangeName), 'simple' => true])];
        }

        if ((CardinalitiesExtractor::CARDINALITY_0_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_N === $property->cardinality) && $property->rangeName) {
            return [new Attribute('MongoDB\ReferenceMany', ['targetDocument' => $this->getRelationName($property->rangeName), 'simple' => true])];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : [new Use_('Doctrine\ODM\MongoDB\Mapping\Annotations', 'MongoDB')];
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(string $rangeName): string
    {
        return isset($this->classes[$rangeName]) && $this->classes[$rangeName]->interfaceName()
            ? $this->classes[$rangeName]->interfaceName() : $rangeName;
    }

    /**
     * @return Attribute[]
     */
    private function generateIdAttributes(): array
    {
        switch ($this->config['id']['generationStrategy']) {
            case 'uuid':
                if ($this->config['id']['writable']) {
                    return [new Attribute('MongoDB\Id', ['strategy' => 'NONE', 'type' => 'bin_uuid'])];
                }

                return [new Attribute('MongoDB\Id', ['strategy' => 'UUID'])];
            case 'auto':
                return [new Attribute('MongoDB\Id', ['strategy' => 'INCREMENT'])];
            case 'mongoid':
                return [new Attribute('MongoDB\Id')];
            default:
                return [new Attribute('MongoDB\Id', ['strategy' => 'NONE', 'type' => 'string'])];
        }
    }
}
