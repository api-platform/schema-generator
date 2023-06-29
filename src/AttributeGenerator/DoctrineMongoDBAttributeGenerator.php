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
use ApiPlatform\SchemaGenerator\Model\Type\CompositeType;
use ApiPlatform\SchemaGenerator\Model\Use_;
use Nette\PhpGenerator\Literal;

use function Symfony\Component\String\u;

/**
 * Doctrine MongoDB attribute generator.
 *
 * @author Andrew Meshchanchuk <andrew.meshchanchuk@gmail.com>>
 */
final class DoctrineMongoDBAttributeGenerator extends AbstractAttributeGenerator
{
    public function generateClassAttributes(Class_ $class): array
    {
        if ($class->isEnum()) {
            return [];
        }

        $attributes = [];
        if ($class->hasChild && ($inheritanceAttributes = $this->config['doctrine']['inheritanceAttributes'])) {
            foreach ($inheritanceAttributes as $configAttributes) {
                foreach ($configAttributes as $attributeName => $attributeArgs) {
                    $attributes[] = new Attribute($attributeName, $attributeArgs ?? []);
                }
            }
        } elseif ($class->isAbstract) {
            $attributes[] = new Attribute('MongoDB\MappedSuperclass');
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

            $attributes[] = new Attribute('MongoDB\Document');
            $attributes[] = new Attribute('MongoDB\InheritanceType', [\in_array($this->config['doctrine']['inheritanceType'], ['SINGLE_COLLECTION', 'COLLECTION_PER_CLASS', 'NONE'], true) ? $this->config['doctrine']['inheritanceType'] : 'SINGLE_COLLECTION']);
            $attributes[] = new Attribute('MongoDB\DiscriminatorField', ['discr']);
            $attributes[] = new Attribute('MongoDB\DiscriminatorMap', [array_reduce($mapNames, fn (array $map, string $mapName) => $map + [u($mapName)->camel()->toString() => new Literal(sprintf('%s::class', $mapName))], [])]);
        } else {
            $attributes[] = new Attribute('MongoDB\Document');
        }

        return $attributes;
    }

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
            $type = $property->isArray() ? 'simple_array' : 'string';
        } elseif (!$property->reference && $property->isArray()) {
            $type = 'collection';
        } elseif ($property->type && !$property->reference && !$property->isArray() && null !== ($phpType = $this->phpTypeConverter->getPhpType($property, $this->config, []))) {
            if ($property->type instanceof CompositeType) {
                $type = 'raw';
            } else {
                switch ((string) $property->type) {
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
                            case 'int':
                                $type = 'integer';
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
        }

        if (null !== $type) {
            return [new Attribute('MongoDB\Field', ['type' => $type])];
        }

        if (null === $relationName = $this->getRelationName($property, $className)) {
            return [];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_0 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_1 === $property->cardinality) {
            return [new Attribute('MongoDB\ReferenceOne', ['targetDocument' => $relationName])];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_N === $property->cardinality) {
            return [new Attribute('MongoDB\ReferenceMany', ['targetDocument' => $relationName])];
        }

        return [];
    }

    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : [new Use_('Doctrine\ODM\MongoDB\Mapping\Annotations', 'MongoDB')];
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(Property $property, string $className): ?string
    {
        $reference = $property->reference;

        if (!$reference) {
            $this->logger ? $this->logger->error('There is no reference for the property "{property}" from the class "{class}"', ['property' => $property->name(), 'class' => $className]) : null;

            return null;
        }

        return $reference->interfaceName() ?: $reference->name();
    }

    /**
     * @return Attribute[]
     */
    private function generateIdAttributes(): array
    {
        switch ($this->config['id']['generationStrategy']) {
            case 'uuid':
                if ($this->config['id']['writable']) {
                    return [new Attribute('MongoDB\Id', ['strategy' => 'NONE', 'type' => 'bin_uuid'])];
                }

                return [new Attribute('MongoDB\Id', ['strategy' => 'UUID'])];
            case 'auto':
                return [new Attribute('MongoDB\Id', ['strategy' => 'INCREMENT'])];
            case 'mongoid':
                return [new Attribute('MongoDB\Id')];
            default:
                return [new Attribute('MongoDB\Id', ['strategy' => 'NONE', 'type' => 'string'])];
        }
    }
}
