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
 * Doctrine annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class DoctrineOrmAnnotationGenerator extends AbstractAnnotationGenerator
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
            $inheritanceMapping = '@ORM\Entity';

            if ($class['abstract']) {
                $inheritanceMapping = '@ORM\MappedSuperclass';
            }

            if ($class['embeddable']) {
                $inheritanceMapping = '@ORM\Embeddable';
            }
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

        $field['relationTableName'] = null;
        if (isset($this->config['types'][$className]['properties'][$fieldName])) {
            $field['relationTableName'] = $this->config['types'][$className]['properties'][$fieldName]['relationTableName'];
        }

        if ($field['isEnum']) {
            $type = $field['isArray'] ? 'simple_array' : 'string';
        } else {
            switch ($field['range']->getUri()) {
                case 'http://schema.org/Boolean':
                    $type = 'boolean';
                    break;
                case 'http://schema.org/Date':
                    $type = 'date';
                    break;
                case 'http://schema.org/DateTime':
                    $type = 'datetime';
                    break;
                case 'http://schema.org/Time':
                    $type = 'time';
                    break;
                case 'http://schema.org/Number':
                case 'http://schema.org/Float':
                    $type = 'float';
                    break;
                case 'http://schema.org/Integer':
                    $type = 'integer';
                    break;
                case 'http://schema.org/Text':
                case 'http://schema.org/URL':
                    $type = 'text';
                    break;
            }
        }

        if (isset($type)) {
            $annotation = '@ORM\Column';
            $isColumnHasProperties = false;

            if ($field['ormColumn']) {
                $annotation .= sprintf('(%s)', $field['ormColumn']);
            } else {
                if ('string' !== $type || $field['isNullable'] || $field['isUnique']) {
                    $isColumnHasProperties = true;
                }

                if ($field['isArray']) {
                    $type = 'simple_array';
                }

                if ($isColumnHasProperties) {
                    $annotation .= '(';
                }

                $annotArr = [];

                if ('string' !== $type) {
                    $annotArr[] = sprintf('type="%s"', $type);
                }

                if ($field['isNullable']) {
                    $annotArr[] = 'nullable=true';
                }

                if ($field['isUnique']) {
                    $annotArr[] = 'unique=true';
                }

                if ($isColumnHasProperties) {
                    if (\count($annotArr) > 0) {
                        $annotation .= implode(', ', $annotArr);
                    }
                    $annotation .= ')';
                }
            }

            $annotations[] = $annotation;

            return $annotations;
        }

        $relationName = $field['range'] ? $this->getRelationName($field['range']->localName()) : null;
        if ($field['isEmbedded']) {
            $columnPrefix = ', columnPrefix=';
            if (\is_bool($field['columnPrefix'])) {
                $columnPrefix .= $field['columnPrefix'] ? 'true' : 'false';
            } else {
                $columnPrefix .= sprintf('"%s"', $field['columnPrefix']);
            }

            if ($relationName) {
                $annotations[] = sprintf('@ORM\Embedded(class="%s"%s)', $relationName, $columnPrefix);
            }

            return $annotations;
        }

        if (!$relationName) {
            return $annotations;
        }

        switch ($field['cardinality']) {
            case CardinalitiesExtractor::CARDINALITY_0_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $relationName);
                break;
            case CardinalitiesExtractor::CARDINALITY_1_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $relationName);
                    $annotations[] = '@ORM\JoinColumn(nullable=false)';
                break;
            case CardinalitiesExtractor::CARDINALITY_UNKNOWN:
            case CardinalitiesExtractor::CARDINALITY_N_0:
                if ($field['inversedBy'] ?? false) {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s", inversedBy="%s")', $relationName, $field['inversedBy']);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $relationName);
                }
                break;
            case CardinalitiesExtractor::CARDINALITY_N_1:
                if ($field['inversedBy'] ?? false) {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s", inversedBy="%s")', $relationName, $field['inversedBy']);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $relationName);
                }
                $annotations[] = '@ORM\JoinColumn(nullable=false)';
                break;
            case CardinalitiesExtractor::CARDINALITY_0_N:
                if ($field['mappedBy'] ?? false) {
                    $annotations[] = sprintf('@ORM\OneToMany(targetEntity="%s", mappedBy="%s")', $relationName, $field['mappedBy']);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $relationName);
                }
                $name = $field['relationTableName'] ? sprintf('name="%s", ', $field['relationTableName']) : '';
                $annotations[] = '@ORM\JoinTable('.$name.'inverseJoinColumns={@ORM\JoinColumn(unique=true)})';
                break;
            case CardinalitiesExtractor::CARDINALITY_1_N:
                if ($field['mappedBy'] ?? false) {
                    $annotations[] = sprintf('@ORM\OneToMany(targetEntity="%s", mappedBy="%s")', $relationName, $field['mappedBy']);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $relationName);
                }
                $name = $field['relationTableName'] ? sprintf('name="%s", ', $field['relationTableName']) : '';
                $annotations[] = '@ORM\JoinTable('.$name.'inverseJoinColumns={@ORM\JoinColumn(nullable=false, unique=true)})';
                break;
            case CardinalitiesExtractor::CARDINALITY_N_N:
                $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $relationName);
                if ($field['relationTableName']) {
                    $annotations[] = sprintf('@ORM\JoinTable(name="%s")', $field['relationTableName']);
                }
                break;
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

        return $typeIsEnum ? [] : ['Doctrine\ORM\Mapping as ORM'];
    }

    private function generateIdAnnotations(): array
    {
        $annotations = ['@ORM\Id'];
        if ('none' !== $this->config['id']['generationStrategy'] && !$this->config['id']['writable']) {
            $annotations[] = sprintf('@ORM\GeneratedValue(strategy="%s")', strtoupper($this->config['id']['generationStrategy']));
        }

        switch ($this->config['id']['generationStrategy']) {
            case 'uuid':
                $type = 'guid';
            break;
            case 'auto':
                $type = 'integer';
            break;
            default:
                $type = 'string';
            break;
        }

        $annotations[] = sprintf('@ORM\Column(type="%s")', $type);

        return $annotations;
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(string $range): ?string
    {
        if (!isset($this->classes[$range])) {
            return null;
        }

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
