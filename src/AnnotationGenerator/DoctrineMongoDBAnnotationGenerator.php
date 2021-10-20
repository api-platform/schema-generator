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
 * Doctrine MongoDB annotation generator.
 *
 * @author Andrew Meshchanchuk <andrew.meshchanchuk@gmail.com>>
 */
final class DoctrineMongoDBAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(Class_ $class): array
    {
        if ($class->isEnum()) {
            return [];
        }

        return [
            '',
            $this->config['types'][$class->name()]['doctrine']['inheritanceMapping'] ?? ($class->isAbstract() ? '@MongoDB\MappedSuperclass' : '@MongoDB\Document'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAnnotations(Property $property, string $className): array
    {
        if (null === $property->range) {
            return [];
        }

        if ($property->isId) {
            return $this->generateIdAnnotations();
        }

        $type = null;
        if ($property->isEnum) {
            $type = $property->isArray ? 'simple_array' : 'string';
        } elseif ($property->isArray ?? false) {
            $type = 'collection';
        } elseif (null !== $phpType = $this->phpTypeConverter->getPhpType($property, $this->config, [])) {
            switch ($property->range->getUri()) {
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
            return [sprintf('@MongoDB\Field(type="%s")', $type)];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_1 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_0 === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_1 === $property->cardinality) {
            return [sprintf('@MongoDB\ReferenceOne(targetDocument="%s", simple=true))', $this->getRelationName($property->rangeName))];
        }

        if (CardinalitiesExtractor::CARDINALITY_0_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_1_N === $property->cardinality
                || CardinalitiesExtractor::CARDINALITY_N_N === $property->cardinality) {
            return [sprintf('@MongoDB\ReferenceMany(targetDocument="%s", simple=true)', $this->getRelationName($property->rangeName))];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : ['Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB'];
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(string $rangeName): string
    {
        return isset($this->classes[$rangeName]) && $this->classes[$rangeName]->interfaceName()
            ? $this->classes[$rangeName]->interfaceName() : $rangeName;
    }

    private function generateIdAnnotations(): array
    {
        switch ($this->config['id']['generationStrategy']) {
            case 'uuid':
                if ($this->config['id']['writable']) {
                    return ['@MongoDB\Id(strategy="NONE", type="bin_uuid")'];
                }

                return ['@MongoDB\Id(strategy="UUID")'];
            case 'auto':
                return ['@MongoDB\Id(strategy="INCREMENT")'];
            case 'mongoid':
                return ['@MongoDB\Id'];
            default:
                return ['@MongoDB\Id(strategy="NONE", type="string")'];
        }
    }
}
