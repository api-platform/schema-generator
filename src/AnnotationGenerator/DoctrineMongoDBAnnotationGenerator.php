<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\TypesGenerator;

/**
 * Doctrine MongoDB annotation generator.
 *
 * @author Andrew Meshchanchuk <andrew.meshchanchuk@gmail.com>>
 */
class DoctrineMongoDBAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
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

        return [
            '',
            $inheritanceMapping,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        $this->classes[$className];
        $field = $this->classes[$className]['fields'][$fieldName];

        $annotations = [];

        if ($field['isEnum']) {
            if ($field['isArray']) {
                $type = 'simple_array';
            } else {
                $type = 'string';
            }
        } else {
            switch ($field['range']) {
                case 'Boolean':
                    $type = 'boolean';
                    break;
                case 'Date':
                    // No break
                case 'DateTime':
                    $type = 'date';
                    break;
                case 'Time':
                    $type = 'time';
                    break;
                case 'Number':
                    // No break
                case 'Float':
                    $type = 'float';
                    break;
                case 'Integer':
                    $type = 'integer';
                    break;
                case 'Text':
                    // No break
                case 'URL':
                    $type = 'string';
                    break;
            }
        }

        if (isset($type)) {
            if (!$field['isId']) {
                $annotation = '@MongoDB\Field';

                if ($field['isArray']) {
                    $type = 'collection';
                }

                $annotation .= sprintf('(type="%s")', $type);

                $annotations[] = $annotation;
            }
        } else {
            if ($field['cardinality'] === CardinalitiesExtractor::CARDINALITY_0_1
                || $field['cardinality'] === CardinalitiesExtractor::CARDINALITY_1_1
                || $field['cardinality'] === CardinalitiesExtractor::CARDINALITY_N_0
                || $field['cardinality'] === CardinalitiesExtractor::CARDINALITY_N_1) {
                $annotations[] = sprintf('@MongoDB\ReferenceOne(targetDocument="%s", simple=true))', $this->getRelationName($field['range']));
            } elseif ($field['cardinality'] === CardinalitiesExtractor::CARDINALITY_0_N
                || $field['cardinality'] === CardinalitiesExtractor::CARDINALITY_1_N
                || $field['cardinality'] === CardinalitiesExtractor::CARDINALITY_N_N) {
                $annotations[] = sprintf('@MongoDB\ReferenceMany(targetDocument="%s", simple=true)', $this->getRelationName($field['range']));
            }
        }

        if ($field['isId']) {
            $annotations[] = '@MongoDB\Id';
        }

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB'];
    }

    /**
     * Gets class or interface name to use in relations.
     *
     * @param string $range
     *
     * @return string
     */
    private function getRelationName($range)
    {
        $class = $this->classes[$range];

        if (isset($class['interfaceName'])) {
            return $class['interfaceName'];
        }

        return $class['name'];
    }
}
