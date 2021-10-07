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
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;

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
    public function generateClassAnnotations(Class_ $class): array
    {
        if ($this->config['types'][$class->name()]['doctrine']['annotations'] ?? false) {
            return array_merge([''], $this->config['types'][$class->name()]['doctrine']['annotations']);
        }

        if ($class->isEnum()) {
            return [];
        }

        if ($class->isEmbeddable()) {
            return ['', '@ORM\Embeddable'];
        }

        $annotations = [''];
        if ($class->isAbstract()) {
            if ($this->config['doctrine']['inheritanceAnnotations'] ?? []) {
                return array_merge($annotations, $this->config['doctrine']['inheritanceAnnotations']);
            }

            $annotations[] = '@ORM\MappedSuperclass';
        } else {
            $annotations[] = '@ORM\Entity';
        }

        foreach (self::RESERVED_KEYWORDS as $keyword) {
            if (0 !== strcasecmp($keyword, $class->name())) {
                continue;
            }

            $annotations[] = sprintf('@ORM\Table(name="`%s`")', strtolower($class->name()));

            return $annotations;
        }

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAnnotations(Property $property, string $className): array
    {
        if (null === $property->rangeName) {
            return [];
        }

        $annotation = '@ORM\Column';
        if ($property->ormColumn !== null) {
            $annotation = sprintf('@ORM\Column(%s)', $property->ormColumn);

            return [$annotation];
        }

        if ($property->isId) {
            return $this->generateIdAnnotations();
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

            if ($property->isNullable) {
                $annotArr[] = 'nullable=true';
            }

            if ($property->isUnique) {
                $annotArr[] = 'unique=true';
            }

            foreach (self::RESERVED_KEYWORDS as $keyword) {
                if (0 === strcasecmp($keyword, $property->name())) {
                    $annotArr[] = sprintf('name="`%s`"', $property->name());
                    break;
                }
            }

            if ($annotArr) {
                $annotation .= sprintf('(%s)', implode(', ', $annotArr));
            }

            return [$annotation];
        }

        if (null === $relationName = $this->getRelationName($property->rangeName)) {
            $this->logger->error('The type "{type}" of the property "{property}" from the class "{class}" doesn\'t exist', ['type' => $property->range->getUri(), 'property' => $property->name(), 'class' => $className]);

            return [];
        }

        if ($property->isEmbedded) {
            $columnPrefix = ', columnPrefix=';
            if (\is_bool($property->columnPrefix)) {
                $columnPrefix .= $property->columnPrefix ? 'true' : 'false';
            } else {
                $columnPrefix .= sprintf('"%s"', $property->columnPrefix);
            }

            return [sprintf('@ORM\Embedded(class="%s"%s)', $relationName, $columnPrefix)];
        }

        $annotations = [];
        switch ($property->cardinality) {
            case CardinalitiesExtractor::CARDINALITY_0_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $relationName);
                break;
            case CardinalitiesExtractor::CARDINALITY_1_1:
                    $annotations[] = sprintf('@ORM\OneToOne(targetEntity="%s")', $relationName);
                    $annotations[] = '@ORM\JoinColumn(nullable=false)';
                break;
            case CardinalitiesExtractor::CARDINALITY_UNKNOWN:
            case CardinalitiesExtractor::CARDINALITY_N_0:
                if ($property->inversedBy !== null) {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s", inversedBy="%s")', $relationName, $property->inversedBy);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $relationName);
                }
                break;
            case CardinalitiesExtractor::CARDINALITY_N_1:
                if ($property->inversedBy !== null) {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s", inversedBy="%s")', $relationName, $property->inversedBy);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToOne(targetEntity="%s")', $relationName);
                }
                $annotations[] = '@ORM\JoinColumn(nullable=false)';
                break;
            case CardinalitiesExtractor::CARDINALITY_0_N:
                if ($property->mappedBy !== null) {
                    $annotations[] = sprintf('@ORM\OneToMany(targetEntity="%s", mappedBy="%s")', $relationName, $property->mappedBy);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $relationName);
                }
                $name = $property->relationTableName ? sprintf('name="%s", ', $property->relationTableName) : '';
                $annotations[] = '@ORM\JoinTable('.$name.'inverseJoinColumns={@ORM\JoinColumn(unique=true)})';
                break;
            case CardinalitiesExtractor::CARDINALITY_1_N:
                if ($property->mappedBy !== null) {
                    $annotations[] = sprintf('@ORM\OneToMany(targetEntity="%s", mappedBy="%s")', $relationName, $property->mappedBy);
                } else {
                    $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $relationName);
                }
                $name = $property->relationTableName ? sprintf('name="%s", ', $property->relationTableName) : '';
                $annotations[] = '@ORM\JoinTable('.$name.'inverseJoinColumns={@ORM\JoinColumn(nullable=false, unique=true)})';
                break;
            case CardinalitiesExtractor::CARDINALITY_N_N:
                $annotations[] = sprintf('@ORM\ManyToMany(targetEntity="%s")', $relationName);
                if ($property->relationTableName) {
                    $annotations[] = sprintf('@ORM\JoinTable(name="%s")', $property->relationTableName);
                }
                break;
        }

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : ['Doctrine\ORM\Mapping as ORM'];
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
