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

namespace ApiPlatform\SchemaGenerator;

use ApiPlatform\SchemaGenerator\ClassMutator\AnnotationsAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\AttributeAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassIdAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassInterfaceMutator;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassParentMutator;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassPropertiesAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassPropertiesTypehintMutator;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGeneratorInterface;
use ApiPlatform\SchemaGenerator\Schema\ClassMutator\EnumClassMutator as SchemaEnumClassMutator;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property as SchemaProperty;
use ApiPlatform\SchemaGenerator\Schema\PropertyGenerator\IdPropertyGenerator;
use ApiPlatform\SchemaGenerator\Schema\PropertyGenerator\PropertyGenerator;
use ApiPlatform\SchemaGenerator\Schema\TypeConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\RdfNamespace;
use EasyRdf\Resource as RdfResource;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\String\Inflector\InflectorInterface;

/**
 * Generates entity files.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class TypesGenerator
{
    use LoggerAwareTrait;

    /**
     * @var string
     *
     * @internal
     */
    public const SCHEMA_ORG_ENUMERATION = 'https://schema.org/Enumeration';

    /**
     * @var string[] the RDF types of classes in the vocabs
     */
    public static array $classTypes = [
      'rdfs:Class',
      'owl:Class',
    ];

    /**
     * @var string[] the RDF types of properties in the vocabs
     */
    public static array $propertyTypes = [
        'rdf:Property',
        'owl:ObjectProperty',
        'owl:DatatypeProperty',
    ];

    /**
     * @var string[] the RDF types of domains in the vocabs
     */
    public static array $domainProperties = [
      'schema:domainIncludes',
      'rdfs:domain',
    ];

    /** @var RdfGraph[] */
    private array $graphs;
    private PhpTypeConverterInterface $phpTypeConverter;
    /** @var array<string, string> */
    private array $cardinalities;
    private InflectorInterface $inflector;
    private PropertyGeneratorInterface $propertyGenerator;

    /**
     * @param RdfGraph[] $graphs
     */
    public function __construct(InflectorInterface $inflector, array $graphs, PhpTypeConverterInterface $phpTypeConverter, CardinalitiesExtractor $cardinalitiesExtractor, GoodRelationsBridge $goodRelationsBridge)
    {
        if (!$graphs) {
            throw new \InvalidArgumentException('At least one graph must be injected.');
        }

        $this->inflector = $inflector;
        $this->graphs = $graphs;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->cardinalities = $cardinalitiesExtractor->extract();
        $this->propertyGenerator = new PropertyGenerator($goodRelationsBridge, new TypeConverter(), $phpTypeConverter, $this->cardinalities);

        RdfNamespace::set('schema', 'https://schema.org/');
    }

    /**
     * Generates files.
     *
     * @param Configuration $config
     *
     * @return Class_[]
     */
    public function generate(array $config): array
    {
        $typesToGenerate = $this->defineTypesToGenerate($config);

        $classes = [];
        $propertiesMap = $this->createPropertiesMap($typesToGenerate, $config);

        foreach ($typesToGenerate as $typeName => $type) {
            if ($type->isBNode()) {
                // Ignore blank nodes
                continue;
            }

            $typeName = $this->phpTypeConverter->escapeIdentifier(\is_string($typeName) ? $typeName : $type->localName());
            if ($type->isA('owl:DeprecatedClass')) {
                if (!isset($config['types'][$typeName])) {
                    continue;
                }

                $this->logger ? $this->logger->warning('The type "{type}" is deprecated', ['type' => $type->getUri()]) : null;
            }

            $typeConfig = $config['types'][$typeName] ?? null;
            $parent = $typeConfig['parent'] ?? null;
            $class = new SchemaClass($typeName, $type, $parent);
            $class->operations = $typeConfig['operations'] ?? [];
            $class->security = $typeConfig['security'] ?? null;

            if ($class->isEnum()) {
                (new SchemaEnumClassMutator(
                    $this->phpTypeConverter,
                    $this->graphs,
                    $config['namespaces']['enum']
                ))($class);
            } else {
                $class->namespace = $typeConfig['namespaces']['class'] ?? $config['namespaces']['entity'];

                // Interfaces
                if ($config['useInterface']) {
                    $interfaceNamespace = isset($typeConfig['namespaces']['interface']) && $typeConfig['namespaces']['interface'] ? $typeConfig['namespaces']['interface'] : $config['namespaces']['interface'];
                    (new ClassInterfaceMutator($interfaceNamespace))($class);
                }

                $classParentMutator = new ClassParentMutator($config, $this->phpTypeConverter);
                if ($this->logger) {
                    $classParentMutator->setLogger($this->logger);
                }
                ($classParentMutator)($class);
            }

            $classPropertiesAppender = new ClassPropertiesAppender($this->propertyGenerator, $config, $propertiesMap, $this->graphs);
            if ($this->logger) {
                $classPropertiesAppender->setLogger($this->logger);
            }
            ($classPropertiesAppender)($class);
            $class->isEmbeddable = $typeConfig['embeddable'] ?? false;

            if ($config['doctrine']['useCollection']) {
                $class->addUse(new Use_(ArrayCollection::class));
                $class->addUse(new Use_(Collection::class));
            }

            $classes[$typeName] = $class;
        }

        // Second pass
        foreach ($classes as $class) {
            /** @var $class SchemaClass */
            if ($class->hasParent() && !$class->isParentEnum()) {
                $parentClass = $classes[$class->parent()] ?? null;
                if (isset($parentClass)) {
                    $parentClass->hasChild = true;
                    $class->parentHasConstructor = $parentClass->hasConstructor;
                } else {
                    $this->logger ? $this->logger->error(sprintf('The type "%s" (parent of "%s") doesn\'t exist', $class->parent(), $class->rdfType())) : null;
                }
            }

            foreach ($class->properties() as $property) {
                if (!$property instanceof SchemaProperty) {
                    throw new \LogicException(sprintf('Property "%s" has to be an instance of "%s".', $property->name(), SchemaProperty::class));
                }
                $typeName = $property->rangeName;
                if (isset($classes[$typeName])) {
                    $property->reference = $classes[$typeName];
                }
            }

            (new ClassPropertiesTypehintMutator($this->phpTypeConverter, $config, $classes))($class);
        }

        // Third pass
        foreach ($classes as $class) {
            /* @var $class SchemaClass */
            $class->isAbstract = $config['types'][$class->name()]['abstract'] ?? $class->hasChild;

            // When including all properties, ignore properties already set on parent
            if (($config['types'][$class->name()]['allProperties'] ?? true) && isset($classes[$class->parent()])) {
                $type = $class->resource();
                foreach ($propertiesMap[$type->getUri()] as $property) {
                    $propertyName = $property->localName();
                    if (!$class->hasProperty($propertyName)) {
                        continue;
                    }

                    $parentConfig = $config['types'][$class->parent()] ?? null;
                    /** @var SchemaClass|null $parentClass */
                    $parentClass = $classes[$class->parent()];

                    while ($parentClass) {
                        if (\array_key_exists($propertyName, $parentConfig['properties'] ?? []) || \in_array($property, $propertiesMap[$parentClass->rdfType()], true)) {
                            $class->removePropertyByName($propertyName);
                            continue 2;
                        }

                        $parentConfig = $parentClass->parent() ? ($config['types'][$parentClass->parent()] ?? null) : null;
                        $parentClass = $parentClass->parent() && isset($classes[$parentClass->parent()]) ? $classes[$parentClass->parent()] : null;
                    }
                }
            }
        }

        // Generate ID
        if ($config['id']['generate']) {
            foreach ($classes as $class) {
                (new ClassIdAppender(new IdPropertyGenerator(), $config))($class);
            }
        }

        // Initialize annotation generators
        $annotationGenerators = [];
        foreach ($config['annotationGenerators'] as $annotationGenerator) {
            $generator = new $annotationGenerator($this->phpTypeConverter, $this->inflector, $config, $classes);
            if (method_exists($generator, 'setLogger')) {
                $generator->setLogger($this->logger);
            }

            $annotationGenerators[] = $generator;
        }

        // Initialize attribute generators
        $attributeGenerators = [];
        foreach ($config['attributeGenerators'] as $attributeGenerator) {
            $generator = new $attributeGenerator($this->phpTypeConverter, $this->inflector, $config, $classes);
            if (method_exists($generator, 'setLogger')) {
                $generator->setLogger($this->logger);
            }

            $attributeGenerators[] = $generator;
        }

        foreach ($classes as $class) {
            (new AnnotationsAppender($classes, $annotationGenerators, $typesToGenerate))($class);
            (new AttributeAppender($classes, $attributeGenerators))($class);
        }

        return $classes;
    }

    /**
     * Gets the parent classes of the current one and add them to $parentClasses array.
     *
     * @param RdfResource[] $parentClasses
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

    /**
     * Creates a map between classes and properties.
     *
     * @param RdfResource[] $types
     * @param Configuration $config
     *
     * @return array<string, RdfResource[]>
     */
    private function createPropertiesMap(array $types, array $config): array
    {
        $typesResources = [];
        $map = [];
        foreach ($types as $type) {
            // get all parent classes until the root
            $parentClasses = $this->getParentClasses($type);
            $typesResources[] = [
                'resources' => $parentClasses,
                'uris' => array_map(static fn (RdfResource $parentClass) => $parentClass->getUri(), $parentClasses),
                'names' => array_map(fn (RdfResource $parentClass) => $this->phpTypeConverter->escapeIdentifier($parentClass->localName()), $parentClasses),
            ];
            $map[$type->getUri()] = [];
        }

        foreach ($this->graphs as $graph) {
            foreach (self::$propertyTypes as $propertyType) {
                /** @var RdfResource $property */
                foreach ($graph->allOfType($propertyType) as $property) {
                    if ($property->isBNode()) {
                        continue;
                    }

                    foreach (self::$domainProperties as $domainPropertyType) {
                        foreach ($property->all($domainPropertyType, 'resource') as $domain) {
                            $this->addPropertyToMap($property, $domain, $typesResources, $config, $map);
                        }
                    }
                }
            }
        }

        return $map;
    }

    /**
     * @param array{resources: RdfResource[], uris: string[], names: string[]}[] $typesResources
     * @param Configuration                $config
     * @param array<string, RdfResource[]> $map
     */
    private function addPropertyToMap(RdfResource $property, RdfResource $domain, array $typesResources, array $config, array &$map): void
    {
        $propertyName = $property->localName();
        $deprecated = $property->isA('owl:DeprecatedProperty');

        if ($domain->isBNode()) {
            if (null !== ($unionOf = $domain->get('owl:unionOf'))) {
                $this->addPropertyToMap($property, $unionOf, $typesResources, $config, $map);

                return;
            }

            if (null !== ($rdfFirst = $domain->get('rdf:first'))) {
                $this->addPropertyToMap($property, $rdfFirst, $typesResources, $config, $map);
                if (null !== ($rdfRest = $domain->get('rdf:rest'))) {
                    $this->addPropertyToMap($property, $rdfRest, $typesResources, $config, $map);
                }
            }

            return;
        }

        foreach ($typesResources as $typesResourceHierarchy) {
            foreach ($typesResourceHierarchy['uris'] as $k => $typeUri) {
                if ($domain->getUri() !== $typeUri) {
                    continue;
                }

                $propertyConfig = $config['types'][$typesResourceHierarchy['names'][$k]]['properties'][$propertyName] ?? null;

                if ($propertyConfig['exclude'] ?? false) {
                    continue;
                }

                if ($deprecated) {
                    if (null === $propertyConfig) {
                        continue;
                    }

                    $this->logger ? $this->logger->warning('The property "{property}" of the type "{type}" is deprecated', ['property' => $property->getUri(), 'type' => $typeUri]) : null;
                }

                $map[$typeUri][] = $property;
            }
        }
    }

    /**
     * @param Configuration $config
     *
     * @return RdfResource[]
     */
    private function defineTypesToGenerate(array $config): array
    {
        $typesToGenerate = [];
        if ($config['allTypes']) {
            foreach ($this->graphs as $graph) {
                foreach (self::$classTypes as $classType) {
                    foreach ($graph->allOfType($classType) as $type) {
                        if (!($config['types'][$this->phpTypeConverter->escapeIdentifier($type->localName())]['exclude'] ?? false)) {
                            $typesToGenerate[] = $type;
                        }
                    }
                }
            }
        } else {
            foreach ($config['types'] as $typeName => $typeConfig) {
                $vocabularyNamespace = $typeConfig['vocabularyNamespace'] ?? $config['vocabularyNamespace'];

                $resource = null;
                foreach ($this->graphs as $graph) {
                    $resources = $graph->resources();

                    $typeIri = $vocabularyNamespace.$typeName;
                    if (isset($resources[$typeIri])) {
                        $resource = $graph->resource($typeIri);
                        break;
                    }
                }

                if ($resource) {
                    $typesToGenerate[$typeName] = $resource;
                } else {
                    $this->logger ? $this->logger->warning('Type "{typeName}" cannot be found. Using "{guessFrom}" type to generate entity.', ['typeName' => $typeName, 'guessFrom' => $typeConfig['guessFrom']]) : null;
                    if (isset($graph)) {
                        $type = $graph->resource($vocabularyNamespace.$typeConfig['guessFrom']);
                        $typesToGenerate[$typeName] = $type;
                    }
                }
            }
        }

        return $typesToGenerate;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
        if (method_exists($this->propertyGenerator, 'setLogger')) {
            $this->propertyGenerator->setLogger($logger);
        }
    }
}
