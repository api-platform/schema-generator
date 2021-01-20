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

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\TypesGenerator;

/**
 * Doctrine MongoDB annotation generator.
 *
 * @author Andrew Meshchanchuk <andrew.meshchanchuk@gmail.com>>
 */
final class DoctrineMongoDBAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(string $className): array
    {
        $class = $this->classes[$className];
        if ($class['isEnum']) {
            return [];
        }

        return [
            '',
            $this->config['types'][$class['name']]['doctrine']['inheritanceMapping'] ?? ($class['abstract'] ? '@MongoDB\MappedSuperclass' : '@MongoDB\Document'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(string $className, string $fieldName): array
    {
        $field = $this->classes[$className]['fields'][$fieldName];
        if (null === $field['range']) {
            return [];
        }

        $field = $this->classes[$className]['fields'][$fieldName];
        if ($field['isId']) {
            return $this->generateIdAnnotations();
        }

        $type = null;
        if ($field['isEnum']) {
            $type = $field['isArray'] ? 'simple_array' : 'string';
        } elseif ($field['isArray'] ?? false) {
            $type = 'collection';
        } elseif (null !== $phpType = $this->phpTypeConverter->getPhpType($field, $this->config, [])) {
            switch ($field['range']->getUri()) {
                case 'http://www.w3.org/2001/XMLSchema#time':
                case 'http://schema.org/Time':
                    $type = 'time';
                    break;
                case 'http://www.w3.org/2001/XMLSchema#dateTime':
                case 'http://schema.org/DateTime':
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
            return [sprintf('@MongoDB\Field(type="%s")', $type)];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_1 === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_1_1 === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_N_0 === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_N_1 === $field['cardinality']) {
            return [sprintf('@MongoDB\ReferenceOne(targetDocument="%s", simple=true))', $this->getRelationName($field['rangeName']))];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_N === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_1_N === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_N_N === $field['cardinality']) {
            return [sprintf('@MongoDB\ReferenceMany(targetDocument="%s", simple=true)', $this->getRelationName($field['rangeName']))];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(string $className): array
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && TypesGenerator::SCHEMA_ORG_ENUMERATION === $subClassOf->getUri();

        return $typeIsEnum ? [] : ['Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB'];
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(string $rangeName): string
    {
        return $this->classes[$rangeName]['interfaceName'] ?? $rangeName;
    }

    private function generateIdAnnotations(): array
    {
        switch ($this->config['id']['generationStrategy']) {
            case 'uuid':
                if ($this->config['id']['writable']) {
                    return ['@MongoDB\Id(strategy="NONE", type="bin_uuid")'];
                }

                return ['@MongoDB\Id(strategy="UUID")'];
            case 'auto':
                return ['@MongoDB\Id(strategy="INCREMENT")'];
            case 'mongoid':
                return ['@MongoDB\Id'];
            default:
                return ['@MongoDB\Id(strategy="NONE", type="string")'];
        }
    }
}
