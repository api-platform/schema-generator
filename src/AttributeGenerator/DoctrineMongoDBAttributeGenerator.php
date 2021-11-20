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
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;

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
        if ($doctrineAttributes = ($this->config['types'][$class->name()]['doctrine']['attributes'] ?? false)) {
            return $doctrineAttributes;
        }

        if ($class->isEnum()) {
            return [];
        }

        $attributes = [];
        if ($class->isAbstract()) {
            if ($inheritanceAttributes = ($this->config['doctrine']['inheritanceAttributes'] ?? [])) {
                return $inheritanceAttributes;
            }

            $attributes[] = ['MongoDB\MappedSuperclass' => []];
        } else {
            $attributes[] = ['MongoDB\Document' => []];
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
            return [['MongoDB\Field' => ['type' => $type]]];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_0 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_1 === $property->cardinality) {
            return [['MongoDB\ReferenceOne' => ['targetDocument' => $this->getRelationName($property->rangeName), 'simple' => true]]];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_N === $property->cardinality) {
            return [['MongoDB\ReferenceMany' => ['targetDocument' => $this->getRelationName($property->rangeName), 'simple' => true]]];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : ['Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB'];
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(string $rangeName): string
    {
        return isset($this->classes[$rangeName]) && $this->classes[$rangeName]->interfaceName()
            ? $this->classes[$rangeName]->interfaceName() : $rangeName;
    }

    private function generateIdAttributes(): array
    {
        switch ($this->config['id']['generationStrategy']) {
            case 'uuid':
                if ($this->config['id']['writable']) {
                    return [['MongoDB\Id' => ['strategy' => 'NONE', 'type' => 'bin_uuid']]];
                }

                return [['MongoDB\Id' => ['strategy' => 'UUID']]];
            case 'auto':
                return [['MongoDB\Id' => ['strategy' => 'INCREMENT']]];
            case 'mongoid':
                return [['MongoDB\Id' => []]];
            default:
                return [['MongoDB\Id' => ['strategy' => 'NONE', 'type' => 'string']]];
        }
    }
}
