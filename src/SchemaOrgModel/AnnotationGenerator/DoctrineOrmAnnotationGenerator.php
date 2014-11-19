<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

use SchemaOrgModel\CardinalitiesExtractor;
use SchemaOrgModel\TypesGenerator;

/**
 * Doctrine annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DoctrineOrmAnnotationGenerator extends AbstractAnnotationGenerator
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
            $inheritanceMapping = null;
        }

        if (!$inheritanceMapping) {
            $inheritanceMapping = $this->config['inheritanceMapping'];
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

        if (isset($this->classes[$field['range']]['isEnum']) && $this->classes[$field['range']]['isEnum']) {
            if (in_array($field['cardinality'], [
                CardinalitiesExtractor::CARDINALITY_0_N,
                CardinalitiesExtractor::CARDINALITY_1_N,
            ])) {
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
                    $type = 'date';
                    break;
                case 'DateTime':
                    $type = 'datetime';
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
            $annotation = '@ORM\Column';

            if ($type !== 'string') {
                $annotation .= sprintf('(type="%s")', $type);
            }

            $annotations[] = $annotation;
        } else {
            switch ($field['cardinality']) {
                case CardinalitiesExtractor::CARDINALITY_0_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $this->getRelationName($field['range']));
                    break;

                case CardinalitiesExtractor::CARDINALITY_1_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $this->getRelationName($field['range']));
                    $annotations[] = '@ORM\JoinColumn(nullable=false)';
                    break;

                case CardinalitiesExtractor::CARDINALITY_0_N:
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $this->getRelationName($field['range']));
                    break;

                case CardinalitiesExtractor::CARDINALITY_1_N:
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $this->getRelationName($field['range']));
                    $annotations[] = '@ORM\JoinColumn(nullable=false)';
                    break;
            }
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

        return $typeIsEnum ? [] : ['Doctrine\ORM\Mapping as ORM'];
    }

    /**
     * Gets class or interface name to use in relations
     *
     * @param  string $range
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
