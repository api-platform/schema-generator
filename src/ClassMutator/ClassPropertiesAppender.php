<?php

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGenerator;
use EasyRdf\Graph;
use EasyRdf\Resource as RdfResource;
use Psr\Log\LoggerInterface;

final class ClassPropertiesAppender implements ClassMutatorInterface
{
    private PropertyGenerator $propertyGenerator;
    private LoggerInterface $logger;
    private array $propertiesMap;
    private array $config;

    private const SCHEMA_ORG_SUPERSEDED_BY = 'schema:supersededBy';
    private static array $classTypes = [
        'rdfs:Class',
        'owl:Class',
    ];
    private array $graphs;


    public function __construct(PropertyGenerator $propertyGenerator, LoggerInterface $logger, array $config, array $propertiesMap, array $graphs)
    {
        $this->propertiesMap = $propertiesMap;
        $this->propertyGenerator = $propertyGenerator;
        $this->logger = $logger;
        $this->config = $config;
        $this->graphs = $graphs;
    }

    public function __invoke(Class_ $class): Class_
    {
        $typeConfig = $this->config['types'][$class->name()];

        if (!($typeConfig['allProperties'] ?? false) && \is_array($typeConfig['properties'] ?? null)) {
            foreach ($typeConfig['properties'] as $key => $value) {
                if ($value['exclude'] ?? false) {
                    continue;
                }

                foreach ($this->getParentClasses($class->resource()) as $typeInHierarchy) {
                    foreach ($this->propertiesMap[$typeInHierarchy->getUri()] as $property) {
                        if ($key !== $property->localName()) {
                            continue;
                        }

                        $class = $this->generateField($this->config, $class, $class->resource(), $typeConfig, $property);
                        continue 3;
                    }
                }

                $class = $this->generateCustomField($key, $class->resource(), $typeConfig, $class, $this->config);
            }
        } else {
            $remainingProperties = $typeConfig['properties'] ?? [];
            // All properties
            foreach ($this->propertiesMap[$class->resourceUri()] as $property) {
                unset($remainingProperties[$property->localName()]);
                if ($property->hasProperty(self::SCHEMA_ORG_SUPERSEDED_BY)) {
                    $supersededBy = $property->get('schema:supersededBy');
                    $this->logger->warning(sprintf('The property "%s" is superseded by "%s". Using the superseding property.', $property->getUri(), $supersededBy->getUri()));
                } else {
                    $class = $this->generateField($this->config, $class, $class->resource(), $typeConfig, $property);
                }
            }

            foreach ($remainingProperties as $key => $remainingProperty) {
                if ($remainingProperty['exclude'] ?? false) {
                    continue;
                }
                $class = $this->generateCustomField($key, $class->resource(), $typeConfig, $class, $this->config);
            }
        }

        return $class;
    }

    /**
     * Add custom fields (not defined in the vocabulary).
     */
    private function generateCustomField(string $propertyName, RdfResource $type, array $typeConfig, Class_ $class, array $config): Class_
    {
        $this->logger->info(sprintf('The property "%s" (type "%s") is a custom property.', $propertyName, $type->getUri()));
        $customResource = new RdfResource('_:'.$propertyName, new Graph());
        $customResource->add('rdfs:range', $type);

        return $this->generateField($config, $class, $type, $typeConfig, $customResource, true);
    }

    /**
     * Updates generated $class with given field config.
     */
    private function generateField(array $config, Class_ $class, RdfResource $type, array $typeConfig, RdfResource $property, bool $isCustom = false): Class_
    {
        return ($this->propertyGenerator)($config, $class, $type, $typeConfig, $property, $isCustom);
    }

    /**
     * Gets the parent classes of the current one and add them to $parentClasses array.
     *
     * @return RdfResource[]
     */
    private function getParentClasses(RdfResource $resource, array $parentClasses = []): array
    {
        if ([] === $parentClasses) {
            return $this->getParentClasses($resource, [$resource]);
        }

        $filterBNodes = fn ($parentClasses) => array_filter($parentClasses, fn ($parentClass) => !$parentClass->isBNode());
        if (!$subclasses = $resource->all('rdfs:subClassOf', 'resource')) {
            return $filterBNodes($parentClasses);
        }

        $parentClassUri = $subclasses[0]->getUri();
        $parentClasses[] = $subclasses[0];

        foreach ($this->graphs as $graph) {
            foreach (self::$classTypes as $classType) {
                foreach ($graph->allOfType($classType) as $type) {
                    if ($type->getUri() === $parentClassUri) {
                        return $this->getParentClasses($type, $parentClasses);
                    }
                }
            }
        }

        return $filterBNodes($parentClasses);
    }
}
