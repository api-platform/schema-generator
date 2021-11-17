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
 * Doctrine attribute generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class DoctrineOrmAttributeGenerator extends AbstractAttributeGenerator
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
    public function generateClassAttributes(Class_ $class): array
    {
        if ($doctrineAttributes = ($this->config['types'][$class->name()]['doctrine']['attributes'] ?? false)) {
            return $doctrineAttributes;
        }

        if ($class->isEnum()) {
            return [];
        }

        if ($class->isEmbeddable()) {
            return [['ORM\Embeddable' => []]];
        }

        $attributes = [];
        if ($class->isAbstract()) {
            if ($inheritanceAttributes = ($this->config['doctrine']['inheritanceAttributes'] ?? [])) {
                return $inheritanceAttributes;
            }

            $attributes[] = ['ORM\MappedSuperclass' => []];
        } else {
            $attributes[] = ['ORM\Entity' => []];
        }

        foreach (self::RESERVED_KEYWORDS as $keyword) {
            if (0 !== strcasecmp($keyword, $class->name())) {
                continue;
            }

            $attributes[] = ['ORM\Table' => ['name' => strtolower($class->name())]];

            return $attributes;
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        if (null === $property->rangeName) {
            return [];
        }

        if ($property->ormColumn) {
            return [['ORM\Column' => $property->ormColumn]];
        }

        if ($property->isId) {
            return $this->generateIdAttributes();
        }

        if (isset($this->config['types'][$className]['properties'][$property->name()])) {
            $property->relationTableName = $this->config['types'][$className]['properties'][$property->name()]['relationTableName'];
        }

        $type = null;
        if ($property->isEnum) {
            $type = $property->isArray ? 'simple_array' : 'string';
        } elseif ($property->isArray) {
            $type = 'json';
        } elseif (null !== $phpType = $this->phpTypeConverter->getPhpType($property, $this->config, [])) {
            switch ($property->range->getUri()) {
                // TODO: use more precise types for int (smallint, bigint...)
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
            $args = [];
            if ('string' !== $type) {
                $args['type'] = $type;
            }

            if ($property->isNullable) {
                $args['nullable'] = true;
            }

            if ($property->isUnique) {
                $args['unique'] = true;
            }

            foreach (self::RESERVED_KEYWORDS as $keyword) {
                if (0 === strcasecmp($keyword, $property->name())) {
                    $args['name'] = sprintf('`%s`', $property->name());
                    break;
                }
            }

            return [['ORM\Column' => $args]];
        }

        if (null === $relationName = $this->getRelationName($property->rangeName)) {
            $this->logger->error('The type "{type}" of the property "{property}" from the class "{class}" doesn\'t exist', ['type' => $property->range->getUri(), 'property' => $property->name(), 'class' => $className]);

            return [];
        }

        if ($property->isEmbedded) {
            return [['ORM\Embedded' => ['class' => $relationName, 'columnPrefix' => $property->columnPrefix]]];
        }

        $attributes = [];
        switch ($property->cardinality) {
            case CardinalitiesExtractor::CARDINALITY_0_1:
                $attributes[] = ['ORM\OneToOne' => ['targetEntity' => $relationName]];
                break;
            case CardinalitiesExtractor::CARDINALITY_1_1:
                $attributes[] = ['ORM\OneToOne' => ['targetEntity' => $relationName]];
                $attributes[] = ['ORM\JoinColumn' => ['nullable' => false]];
                break;
            case CardinalitiesExtractor::CARDINALITY_UNKNOWN:
            case CardinalitiesExtractor::CARDINALITY_N_0:
                if (null !== $property->inversedBy) {
                    $attributes[] = ['ORM\ManyToOne' => ['targetEntity' => $relationName, 'inversedBy' => $property->inversedBy]];
                } else {
                    $attributes[] = ['ORM\ManyToOne' => ['targetEntity' => $relationName]];
                }
                break;
            case CardinalitiesExtractor::CARDINALITY_N_1:
                if (null !== $property->inversedBy) {
                    $attributes[] = ['ORM\ManyToOne' => ['targetEntity' => $relationName, 'inversedBy' => $property->inversedBy]];
                } else {
                    $attributes[] = ['ORM\ManyToOne' => ['targetEntity' => $relationName]];
                }
                $attributes[] = ['ORM\JoinColumn' => ['nullable' => false]];
                break;
            case CardinalitiesExtractor::CARDINALITY_0_N:
                if (null !== $property->mappedBy) {
                    $attributes[] = ['ORM\OneToMany' => ['targetEntity' => $relationName, 'mappedBy' => $property->mappedBy]];
                } else {
                    $attributes[] = ['ORM\ManyToMany' => ['targetEntity' => $relationName]];
                }
                if ($property->relationTableName) {
                    $attributes[] = ['ORM\JoinTable' => ['name' => $property->relationTableName]];
                }
                $attributes[] = ['ORM\InverseJoinColumn' => ['unique' => true]];
                break;
            case CardinalitiesExtractor::CARDINALITY_1_N:
                if (null !== $property->mappedBy) {
                    $attributes[] = ['ORM\OneToMany' => ['targetEntity' => $relationName, 'mappedBy' => $property->mappedBy]];
                } else {
                    $attributes[] = ['ORM\ManyToMany' => ['targetEntity' => $relationName]];
                }
                if ($property->relationTableName) {
                    $attributes[] = ['ORM\JoinTable' => ['name' => $property->relationTableName]];
                }
                $attributes[] = ['ORM\InverseJoinColumn' => ['nullable' => false, 'unique' => true]];
                break;
            case CardinalitiesExtractor::CARDINALITY_N_N:
                $attributes[] = ['ORM\ManyToMany' => ['targetEntity' => $relationName]];
                if ($property->relationTableName) {
                    $attributes[] = ['ORM\JoinTable' => ['name' => $property->relationTableName]];
                }
                break;
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : ['Doctrine\ORM\Mapping as ORM'];
    }

    private function generateIdAttributes(): array
    {
        $attributes = [['ORM\Id' => []]];
        if ('none' !== $this->config['id']['generationStrategy'] && !$this->config['id']['writable']) {
            $attributes[] = ['ORM\GeneratedValue' => ['strategy' => strtoupper($this->config['id']['generationStrategy'])]];
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

        $attributes[] = ['ORM\Column' => ['type' => $type]];

        return $attributes;
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

        if (null !== $class->interfaceName()) {
            if (isset($this->config['types'][$rangeName]['namespaces']['interface'])) {
                return sprintf('%s\\%s', $this->config['types'][$class->name()]['namespaces']['interface'], $class->interfaceName());
            }

            if (isset($this->config['namespaces']['interface'])) {
                return sprintf('%s\\%s', $this->config['namespaces']['interface'], $class->interfaceName());
            }

            return $class->interfaceName();
        }

        if (isset($this->config['types'][$rangeName]['namespaces']['class'])) {
            return sprintf('%s\\%s', $this->config['types'][$class->name()]['namespaces']['class'], $class->name());
        }

        if (isset($this->config['namespaces']['entity'])) {
            return sprintf('%s\\%s', $this->config['namespaces']['entity'], $rangeName);
        }

        return $rangeName;
    }
}
