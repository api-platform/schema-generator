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
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;
use Nette\PhpGenerator\Literal;
use function Symfony\Component\String\u;

/**
 * Doctrine attribute generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class DoctrineOrmAttributeGenerator extends AbstractAttributeGenerator
{
    use GenerateIdentifierNameTrait;

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
        if ($class->isEnum()) {
            return [];
        }

        if ($class->isEmbeddable) {
            return [new Attribute('ORM\Embeddable')];
        }

        $attributes = [];
        if ($class->hasChild && ($inheritanceAttributes = $this->config['doctrine']['inheritanceAttributes'])) {
            foreach ($inheritanceAttributes as $attributeName => $attributeArgs) {
                $attributes[] = new Attribute($attributeName, $attributeArgs);
            }
        } elseif ($class->isAbstract) {
            $attributes[] = new Attribute('ORM\MappedSuperclass');
        } elseif ($class->hasChild && $class->isReferencedBy) {
            $parentNames = [$class->name()];
            $childNames = [];
            while (!empty($parentNames)) {
                $directChildren = [];
                foreach ($parentNames as $parentName) {
                    $directChildren = array_merge($directChildren, array_filter($this->classes, fn (Class_ $childClass) => $parentName === $childClass->parent()));
                }
                $parentNames = array_keys($directChildren);
                $childNames = array_merge($childNames, array_keys(array_filter($directChildren, fn (Class_ $childClass) => !$childClass->isAbstract)));
            }
            $mapNames = array_merge([$class->name()], $childNames);

            $attributes[] = new Attribute('ORM\Entity');
            $attributes[] = new Attribute('ORM\InheritanceType', [\in_array($this->config['doctrine']['inheritanceType'], ['JOINED', 'SINGLE_TABLE', 'TABLE_PER_CLASS', 'NONE'], true) ? $this->config['doctrine']['inheritanceType'] : 'JOINED']);
            $attributes[] = new Attribute('ORM\DiscriminatorColumn', ['name' => 'discr']);
            $attributes[] = new Attribute('ORM\DiscriminatorMap', [array_reduce($mapNames, fn (array $map, string $mapName) => $map + [u($mapName)->camel()->toString() => new Literal(sprintf('%s::class', $mapName))], [])]);
        } else {
            $attributes[] = new Attribute('ORM\Entity');
        }

        foreach (self::RESERVED_KEYWORDS as $keyword) {
            if (0 !== strcasecmp($keyword, $class->name())) {
                continue;
            }

            $attributes[] = new Attribute('ORM\Table', ['name' => $this->generateIdentifierName($class->name(), 'table', $this->config)]);
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        if (null === $property->type && null === $property->reference) {
            return [];
        }

        if ($property->isId) {
            return $this->generateIdAttributes();
        }

        $type = null;
        if ($property->isEnum) {
            $type = $property->isArray ? 'simple_array' : 'string';
        } elseif ($property->isArray && $property->type) {
            $type = 'json';
        } elseif (!$property->isArray && $property->type && !$property->reference && null !== ($phpType = $this->phpTypeConverter->getPhpType($property, $this->config, []))) {
            switch ($property->type) {
                case 'time':
                    $type = 'time';
                    break;
                case 'dateTime':
                    $type = 'date';
                    break;
                default:
                    $type = $phpType;
                    switch ($phpType) {
                        case 'bool':
                            $type = 'boolean';
                            break;
                        // TODO: use more precise types for int (smallint, bigint...)
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

            return [new Attribute('ORM\Column', $args)];
        }

        if (!$property->reference) {
            $this->logger ? $this->logger->error('There is no reference for the property "{property}" from the class "{class}"', ['property' => $property->name(), 'class' => $className]) : null;

            return [];
        }

        if (null === $relationName = $this->getRelationName($property)) {
            return [];
        }

        if ($property->isEmbedded) {
            return [new Attribute('ORM\Embedded', ['class' => $relationName])];
        }

        $relationTableName = $this->generateIdentifierName($className.ucfirst($property->reference->name()).ucfirst($property->name()), 'join_table', $this->config);

        $attributes = [];
        switch ($property->cardinality) {
            case CardinalitiesExtractor::CARDINALITY_0_1:
                $attributes[] = new Attribute('ORM\OneToOne', ['targetEntity' => $relationName]);
                break;
            case CardinalitiesExtractor::CARDINALITY_1_1:
                $attributes[] = new Attribute('ORM\OneToOne', ['targetEntity' => $relationName]);
                $attributes[] = new Attribute('ORM\JoinColumn', ['nullable' => false]);
                break;
            case CardinalitiesExtractor::CARDINALITY_UNKNOWN:
            case CardinalitiesExtractor::CARDINALITY_N_0:
                if (null !== $property->inversedBy) {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName, 'inversedBy' => $property->inversedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName]);
                }
                break;
            case CardinalitiesExtractor::CARDINALITY_N_1:
                if (null !== $property->inversedBy) {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName, 'inversedBy' => $property->inversedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName]);
                }
                $attributes[] = new Attribute('ORM\JoinColumn', ['nullable' => false]);
                break;
            case CardinalitiesExtractor::CARDINALITY_0_N:
                if (null !== $property->mappedBy) {
                    $attributes[] = new Attribute('ORM\OneToMany', ['targetEntity' => $relationName, 'mappedBy' => $property->mappedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToMany', ['targetEntity' => $relationName]);
                }
                $attributes[] = new Attribute('ORM\JoinTable', ['name' => $relationTableName]);
                $attributes[] = new Attribute('ORM\InverseJoinColumn', ['unique' => true]);
                break;
            case CardinalitiesExtractor::CARDINALITY_1_N:
                if (null !== $property->mappedBy) {
                    $attributes[] = new Attribute('ORM\OneToMany', ['targetEntity' => $relationName, 'mappedBy' => $property->mappedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToMany', ['targetEntity' => $relationName]);
                }
                $attributes[] = new Attribute('ORM\JoinTable', ['name' => $relationTableName]);
                $attributes[] = new Attribute('ORM\InverseJoinColumn', ['nullable' => false, 'unique' => true]);
                break;
            case CardinalitiesExtractor::CARDINALITY_N_N:
                $attributes[] = new Attribute('ORM\ManyToMany', ['targetEntity' => $relationName]);
                $attributes[] = new Attribute('ORM\JoinTable', ['name' => $relationTableName]);
                break;
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : [new Use_('Doctrine\ORM\Mapping', 'ORM')];
    }

    /**
     * @return Attribute[]
     */
    private function generateIdAttributes(): array
    {
        $attributes = [new Attribute('ORM\Id')];
        if ('none' !== $this->config['id']['generationStrategy'] && !$this->config['id']['writable']) {
            $attributes[] = new Attribute('ORM\GeneratedValue', ['strategy' => strtoupper($this->config['id']['generationStrategy'])]);
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

        $attributes[] = new Attribute('ORM\Column', ['type' => $type]);

        return $attributes;
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(Property $property): ?string
    {
        $reference = $property->reference;

        if (!$reference) {
            return null;
        }

        if (null !== $reference->interfaceName()) {
            if (isset($this->config['types'][$reference->name()]['namespaces']['interface'])) {
                return sprintf('%s\\%s', $this->config['types'][$reference->name()]['namespaces']['interface'], $reference->interfaceName());
            }

            return sprintf('%s\\%s', $this->config['namespaces']['interface'], $reference->interfaceName());
        }

        if (isset($this->config['types'][$reference->name()]['namespaces']['class'])) {
            return sprintf('%s\\%s', $this->config['types'][$reference->name()]['namespaces']['class'], $reference->name());
        }

        return sprintf('%s\\%s', $this->config['namespaces']['entity'], $reference->name());
    }
}
