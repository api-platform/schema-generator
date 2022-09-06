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

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGeneratorInterface;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use Psr\Log\LoggerAwareTrait;

final class ClassPropertiesAppender implements ClassMutatorInterface
{
    use LoggerAwareTrait;

    private PropertyGeneratorInterface $propertyGenerator;
    /** @var array<string, RdfResource[]> */
    private array $propertiesMap;
    /** @var Configuration */
    private array $config;

    private const SCHEMA_ORG_SUPERSEDED_BY = 'schema:supersededBy';
    /** @var string[] */
    private static array $classTypes = [
        'rdfs:Class',
        'owl:Class',
    ];

    /**
     * @param Configuration                $config
     * @param array<string, RdfResource[]> $propertiesMap
     */
    public function __construct(PropertyGeneratorInterface $propertyGenerator, array $config, array $propertiesMap)
    {
        $this->propertiesMap = $propertiesMap;
        $this->propertyGenerator = $propertyGenerator;
        $this->config = $config;
    }

    /**
     * @param array{graphs: RdfGraph[], cardinalities: array<string, string>} $context
     */
    public function __invoke(Class_ $class, array $context): void
    {
        if (!$class instanceof SchemaClass) {
            return;
        }

        $graphs = $context['graphs'];
        $cardinalities = $context['cardinalities'];

        $typeConfig = $this->config['types'][$class->name()] ?? null;

        if (null !== $typeConfig && !$typeConfig['allProperties']) {
            foreach ($typeConfig['properties'] as $key => $value) {
                if ($value['exclude']) {
                    continue;
                }

                foreach ($this->getParentClasses($graphs, $class->resource()) as $typeInHierarchy) {
                    foreach ($this->propertiesMap[$typeInHierarchy->getUri()] ?? [] as $property) {
                        if ($key !== $property->localName()) {
                            continue;
                        }

                        $this->generateField($this->config, $class, $class->resource(), $typeConfig, $cardinalities, $property);
                        continue 3;
                    }
                }

                $this->generateCustomField($key, $class->resource(), $typeConfig, $cardinalities, $class, $this->config);
            }
        } else {
            $remainingProperties = $typeConfig['properties'] ?? [];
            if (!isset($this->propertiesMap[$class->rdfType()])) {
                $this->logger ? $this->logger->warning(sprintf('Properties for "%s" not found in the map.', $class->rdfType())) : null;
            }
            // All properties
            foreach ($this->propertiesMap[$class->rdfType()] ?? [] as $property) {
                if (\is_string($property->localName())) {
                    unset($remainingProperties[$property->localName()]);
                }
                if ($property->hasProperty(self::SCHEMA_ORG_SUPERSEDED_BY)) {
                    $supersededBy = $property->get(self::SCHEMA_ORG_SUPERSEDED_BY);
                    $this->logger ? $this->logger->info(sprintf('The property "%s" is superseded by "%s". Using the superseding property.', $property->getUri(), $supersededBy->getUri())) : null;
                } else {
                    $this->generateField($this->config, $class, $class->resource(), $typeConfig, $cardinalities, $property);
                }
            }

            foreach ($remainingProperties as $key => $remainingProperty) {
                if ($remainingProperty['exclude']) {
                    continue;
                }
                $this->generateCustomField($key, $class->resource(), $typeConfig, $cardinalities, $class, $this->config);
            }
        }
    }

    /**
     * Add custom fields (not defined in the vocabulary).
     *
     * @param ?TypeConfiguration    $typeConfig
     * @param Configuration         $config
     * @param array<string, string> $cardinalities
     */
    private function generateCustomField(string $propertyName, RdfResource $type, ?array $typeConfig, array $cardinalities, SchemaClass $class, array $config): void
    {
        $this->logger ? $this->logger->info(sprintf('The property "%s" (type "%s") is a custom property.', $propertyName, $type->getUri())) : null;
        $customResource = new RdfResource('_:'.$propertyName, new RdfGraph());
        $customResource->add('rdfs:range', $type);

        $this->generateField($config, $class, $type, $typeConfig, $cardinalities, $customResource, true);
    }

    /**
     * Updates generated $class with given field config.
     *
     * @param Configuration         $config
     * @param ?TypeConfiguration    $typeConfig
     * @param array<string, string> $cardinalities
     */
    private function generateField(array $config, SchemaClass $class, RdfResource $type, ?array $typeConfig, array $cardinalities, RdfResource $typeProperty, bool $isCustom = false): void
    {
        $property = null;

        if (\is_string($typeProperty->localName())) {
            $property = ($this->propertyGenerator)($typeProperty->localName(), $config, $class, ['type' => $type, 'typeConfig' => $typeConfig, 'cardinalities' => $cardinalities, 'property' => $typeProperty], $isCustom);
        }

        if ($property) {
            $class->addProperty($property);
        }
    }

    /**
     * Gets the parent classes of the current one and add them to $parentClasses array.
     *
     * @param RdfGraph[]    $graphs
     * @param RdfResource[] $parentClasses
     *
     * @return RdfResource[]
     */
    private function getParentClasses(array $graphs, RdfResource $resource, array $parentClasses = []): array
    {
        if ([] === $parentClasses) {
            return $this->getParentClasses($graphs, $resource, [$resource]);
        }

        $filterBNodes = fn ($parentClasses) => array_filter($parentClasses, fn ($parentClass) => !$parentClass->isBNode());
        if (!$subclasses = $resource->all('rdfs:subClassOf', 'resource')) {
            return $filterBNodes($parentClasses);
        }

        $parentClassUri = $subclasses[0]->getUri();
        $parentClasses[] = $subclasses[0];

        foreach ($graphs as $graph) {
            foreach (self::$classTypes as $classType) {
                foreach ($graph->allOfType($classType) as $type) {
                    if ($type->getUri() === $parentClassUri) {
                        return $this->getParentClasses($graphs, $type, $parentClasses);
                    }
                }
            }
        }

        return $filterBNodes($parentClasses);
    }
}
