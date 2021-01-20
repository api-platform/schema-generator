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
    private const RESERVED_KEYWORDS = [
        'add',
        'create',
        'delete',
        'group',
        'join',
        'like',
        'update',
        'to',
    ];

    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(string $className): array
    {
        $class = $this->classes[$className];
        if ($this->config['types'][$class['name']]['doctrine']['annotations'] ?? false) {
            return array_merge([''], $this->config['types'][$class['name']]['doctrine']['annotations']);
        }

        if ($class['isEnum']) {
            return [];
        }

        if ($class['embeddable']) {
            return ['', '@ORM\Embeddable'];
        }

        $annotations = [''];
        if ($class['abstract']) {
            if ($this->config['doctrine']['inheritanceAnnotations'] ?? []) {
                return array_merge($annotations, $this->config['doctrine']['inheritanceAnnotations']);
            }

            $annotations[] = '@ORM\MappedSuperclass';
        } else {
            $annotations[] = '@ORM\Entity';
        }

        foreach (self::RESERVED_KEYWORDS as $keyword) {
            if (0 !== strcasecmp($keyword, $className)) {
                continue;
            }

            $annotations[] = sprintf('@ORM\Table(name="`%s`")', strtolower($className));

            return $annotations;
        }

        return $annotations;
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

        $annotation = '@ORM\Column';
        if ($field['ormColumn'] ?? false) {
            $annotation .= sprintf('(%s)', $field['ormColumn']);

            return [$annotation];
        }

        if ($field['isId']) {
            return $this->generateIdAnnotations();
        }

        $field['relationTableName'] = null;
        if (isset($this->config['types'][$className]['properties'][$fieldName])) {
            $field['relationTableName'] = $this->config['types'][$className]['properties'][$fieldName]['relationTableName'];
        }

        $type = null;
        if ($field['isEnum']) {
            $type = $field['isArray'] ? 'simple_array' : 'string';
        } elseif ($field['isArray'] ?? false) {
            $type = 'json';
        } elseif (null !== $phpType = $this->phpTypeConverter->getPhpType($field, $this->config, [])) {
            switch ($field['range']->getUri()) {
                // TODO: use more precise types for int (smallint, bigint...)
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
                        case 'string':
                            $type = 'text';
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

            foreach (self::RESERVED_KEYWORDS as $keyword) {
                if (0 === strcasecmp($keyword, $fieldName)) {
                    $annotArr[] = sprintf('name="`%s`"', $fieldName);
                    break;
                }
            }

            if ($annotArr) {
                $annotation .= sprintf('(%s)', implode(', ', $annotArr));
            }

            return [$annotation];
        }

        if (null === $relationName = $this->getRelationName($field['rangeName'])) {
            $this->logger->error('The type "{type}" of the property "{property}" from the class "{class}" doesn\'t exist', ['type' => $field['range']->getUri(), 'property' => $field['name'], 'class' => $className]);

            return [];
        }

        if ($field['isEmbedded']) {
            $columnPrefix = ', columnPrefix=';
            if (\is_bool($field['columnPrefix'])) {
                $columnPrefix .= $field['columnPrefix'] ? 'true' : 'false';
            } else {
                $columnPrefix .= sprintf('"%s"', $field['columnPrefix']);
            }

            return [sprintf('@ORM\Embedded(class="%s"%s)', $relationName, $columnPrefix)];
        }

        $annotations = [];
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
    private function getRelationName(string $rangeName): ?string
    {
        if (!isset($this->classes[$rangeName])) {
            return null;
        }

        $class = $this->classes[$rangeName];

        if (isset($class['interfaceName'])) {
            return $class['interfaceName'];
        }

        if (isset($this->config['types'][$rangeName]['namespaces']['class'])) {
            return sprintf('%s\\%s', $this->config['types'][$class['name']]['namespaces']['class'], $class['name']);
        }

        if (isset($this->config['namespaces']['entity'])) {
            return sprintf('%s\\%s', $this->config['namespaces']['entity'], $rangeName);
        }

        return $rangeName;
    }
}
