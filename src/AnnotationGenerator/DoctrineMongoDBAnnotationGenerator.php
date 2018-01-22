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

        if (isset($this->config['types'][$class['resource']->localName()]['doctrine']['inheritanceMapping'])) {
            $inheritanceMapping = $this->config['types'][$class['resource']->localName()]['doctrine']['inheritanceMapping'];
        } else {
            $inheritanceMapping = $class['abstract'] ? '@MongoDB\MappedSuperclass' : '@MongoDB\Document';
        }

        return ['', $inheritanceMapping];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(string $className, string $fieldName): array
    {
        $field = $this->classes[$className]['fields'][$fieldName];
        if ($field['isId']) {
            return $this->generateIdAnnotations();
        }

        $annotations = [];

        if ($field['isEnum']) {
            $type = $field['isArray'] ? 'simple_array' : 'string';
        } else {
            switch ($field['range']) {
                case 'Boolean':
                    $type = 'boolean';
                    break;
                case 'Date':
                case 'DateTime':
                    $type = 'date';
                    break;
                case 'Time':
                    $type = 'time';
                    break;
                case 'Number':
                case 'Float':
                    $type = 'float';
                    break;
                case 'Integer':
                    $type = 'integer';
                    break;
                case 'Text':
                case 'URL':
                    $type = 'string';
                    break;
            }
        }

        if (isset($type)) {
            $annotation = '@MongoDB\Field';

            if ($field['isArray']) {
                $type = 'collection';
            }

            $annotation .= sprintf('(type="%s")', $type);

            $annotations[] = $annotation;
        } else {
            if (CardinalitiesExtractor::CARDINALITY_0_1 === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_1_1 === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_N_0 === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_N_1 === $field['cardinality']) {
                $annotations[] = sprintf('@MongoDB\ReferenceOne(targetDocument="%s", simple=true))', $this->getRelationName($field['range']));
            } elseif (CardinalitiesExtractor::CARDINALITY_0_N === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_1_N === $field['cardinality']
                || CardinalitiesExtractor::CARDINALITY_N_N === $field['cardinality']) {
                $annotations[] = sprintf('@MongoDB\ReferenceMany(targetDocument="%s", simple=true)', $this->getRelationName($field['range']));
            }
        }

        return $annotations;
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
    private function getRelationName(string $range): string
    {
        $class = $this->classes[$range];

        return $class[$range]['interfaceName'] ?? $class['name'];
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
