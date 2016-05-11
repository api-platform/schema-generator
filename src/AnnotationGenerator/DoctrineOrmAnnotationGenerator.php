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
            $inheritanceMapping = '@ORM\Entity';

            if ($class['abstract']) {
                $inheritanceMapping = '@ORM\MappedSuperclass';
            }

            if ($class['embeddable']) {
                $inheritanceMapping = '@ORM\Embeddable';
            }
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

            if ($field['ormColumn']) {
                $annotation .= '('.$field['ormColumn'].')';
            } else {
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
            }

            $annotations[] = $annotation;
        } elseif ($field['isEmbedded']) {
            $columnPrefix = $field['columnPrefix'] ? ', columnPrefix=true' : ', columnPrefix=false';
            $annotations[] = sprintf('@ORM\Embedded(class="%s"%s)', $this->getRelationName($field['range']), $columnPrefix);
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

        if (isset($this->config['types'][$class['name']]['namespaces']['class'])) {
            return sprintf('%s\\%s', $this->config['types'][$class['name']]['namespaces']['class'], $class['name']);
        }

        if (isset($this->config['namespaces']['entity'])) {
            return sprintf('%s\\%s', $this->config['namespaces']['entity'], $class['name']);
        }

        return $class['name'];
    }
}
