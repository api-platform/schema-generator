<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\TypesGenerator;

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
            $inheritanceMapping = $class['abstract'] ? '@ORM\MappedSuperclass' : '@ORM\Entity';
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

        $field['relationTableName'] = null;
        if (!$field['isId'] && isset($this->config['types'][$className]['properties'][$fieldName])) {
            $field['relationTableName'] = $this->config['types'][$className]['properties'][$fieldName]['relationTableName'];
        }
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
            $isColumnHasProperties = false;

            if ($type !== 'string' || $field['isNullable'] || $field['isUnique']) {
                $isColumnHasProperties = true;
            }

            if ($field['isArray']) {
                $type = 'simple_array';
            }

            if ($isColumnHasProperties) {
                $annotation .= '(';
            }

            if ($type !== 'string') {
                $annotation .= sprintf('type="%s"', $type);
            }

            if ($type !== 'string' && $field['isNullable']) {
                $annotation .= ', ';
            }

            if ($field['isNullable']) {
                $annotation .= 'nullable=true';
            }

            if ($field['isUnique'] && $field['isNullable']) {
                $annotation .= ', ';
            }

            if ($field['isUnique']) {
                $annotation .= 'unique=true';
            }

            if ($isColumnHasProperties) {
                $annotation .= ')';
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

                case CardinalitiesExtractor::CARDINALITY_UNKNOWN:
                    // No break
                case CardinalitiesExtractor::CARDINALITY_N_0:
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $this->getRelationName($field['range']));
                    break;

                case CardinalitiesExtractor::CARDINALITY_N_1:
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $this->getRelationName($field['range']));
                    $annotations[] = '@ORM\JoinColumn(nullable=false)';
                    break;

                case CardinalitiesExtractor::CARDINALITY_0_N:
                    $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $this->getRelationName($field['range']));
                    $name = $field['relationTableName'] ? sprintf('name="%s", ', $field['relationTableName']) : '';
                    $annotations[] = '@ORM\JoinTable('.$name.'inverseJoinColumns={@ORM\JoinColumn(unique=true)})';
                    break;

                case CardinalitiesExtractor::CARDINALITY_1_N:
                    $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $this->getRelationName($field['range']));
                    $name = $field['relationTableName'] ? sprintf('name="%s", ', $field['relationTableName']) : '';
                    $annotations[] = '@ORM\JoinTable('.$name.'inverseJoinColumns={@ORM\JoinColumn(nullable=false, unique=true)})';
                    break;

                case CardinalitiesExtractor::CARDINALITY_N_N:
                    $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $this->getRelationName($field['range']));
                    if ($field['relationTableName']) {
                        $annotations[] = sprintf('@ORM\JoinTable(name="%s")', $field['relationTableName']);
                    }
                    break;
            }
        }

        if ($field['isId']) {
            $annotations[] = '@ORM\Id';
            $annotations[] = '@ORM\GeneratedValue(strategy="AUTO")';
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

        if (isset($this->config['types'][$class['name']]['namespaces']['class']) && null !== $this->config['types'][$class['name']]['namespaces']['class']) {
            return $this->config['types'][$class['name']]['namespaces']['class'].'\\'.$class['name'];
        }

        if (isset($this->config['namespaces']['entity']) && null !== $this->config['namespaces']['entity']) {
            return $this->config['namespaces']['entity'].'\\'.$class['name'];
        }

        return $class['name'];
    }
}
