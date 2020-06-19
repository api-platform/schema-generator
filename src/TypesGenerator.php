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

use ApiPlatform\SchemaGenerator\AnnotationGenerator\AnnotationGeneratorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Inflector\Inflector;
use EasyRdf\Graph;
use EasyRdf\Resource;
use MyCLabs\Enum\Enum;
use PhpCsFixer\Cache\NullCacheManager;
use PhpCsFixer\Differ\NullDiffer;
use PhpCsFixer\Error\ErrorsManager;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\Linter\Linter;
use PhpCsFixer\RuleSet;
use PhpCsFixer\Runner\Runner;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

/**
 * Generates entity files.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class TypesGenerator
{
    /**
     * @var string
     *
     * @internal
     */
    public const SCHEMA_ORG_ENUMERATION = 'http://schema.org/Enumeration';

    /**
     * @var string
     */
    private const SCHEMA_ORG_SUPERSEDED_BY = 'schema:supersededBy';

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
        'ObjectProperty',
        'owl:DatatypeProperty',
    ];

    /**
     * @var string[] the RDF types of domains in the vocabs
     */
    public static array $domainProperties = [
      'schema:domainIncludes',
      'rdfs:domain',
    ];

    /**
     * @var string[] the RDF types of ranges in the vocabs
     */
    public static array $rangeProperties = [
        'schema:rangeIncludes',
        'rdfs:range',
    ];

    private Environment $twig;
    private LoggerInterface $logger;
    /**
     * @var Graph[]
     */
    private array $graphs;
    private PhpTypeConverterInterface $phpTypeConverter;
    private GoodRelationsBridge $goodRelationsBridge;
    private array $cardinalities;
    private Inflector $inflector;
    private Filesystem $filesystem;

    /**
     * @param Graph[] $graphs
     */
    public function __construct(Inflector $inflector, Environment $twig, LoggerInterface $logger, array $graphs, PhpTypeConverterInterface $phpTypeConverter, CardinalitiesExtractor $cardinalitiesExtractor, GoodRelationsBridge $goodRelationsBridge)
    {
        if (!$graphs) {
            throw new \InvalidArgumentException('At least one graph must be injected.');
        }

        $this->inflector = $inflector;
        $this->twig = $twig;
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->goodRelationsBridge = $goodRelationsBridge;
        $this->filesystem = new Filesystem();

        $this->cardinalities = $cardinalitiesExtractor->extract();
    }

    /**
     * Generates files.
     */
    public function generate(array $config): void
    {
        $baseClass = [
            'constants' => [],
            'fields' => [],
            'uses' => [],
            'hasConstructor' => false,
            'parentHasConstructor' => false,
            'hasChild' => false,
            'abstract' => false,
        ];

        $typesToGenerate = [];
        if (!$config['types']) {
            foreach ($this->graphs as $graph) {
                foreach (self::$classTypes as $type) {
                    $typesToGenerate[] = $graph->allOfType($type);
                }
            }
            $typesToGenerate = array_merge(...$typesToGenerate);
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
                    $this->logger->warning('Type "{typeName}" cannot be found. Using "{guessFrom}" type to generate entity.', ['typeName' => $typeName, 'guessFrom' => $typeConfig['guessFrom']]);
                    if (isset($graph)) {
                        $type = $graph->resource($vocabularyNamespace.$typeConfig['guessFrom']);
                        $typesToGenerate[$typeName] = $type;
                    }
                }
            }
        }

        $classes = [];
        $propertiesMap = $this->createPropertiesMap($typesToGenerate, $config);

        foreach ($typesToGenerate as $typeName => $type) {
            if ($type->isBNode()) {
                // Ignore blank nodes
                continue;
            }

            $typeName = \is_string($typeName) ? $typeName : $type->localName();
            if ($type->isA('owl:DeprecatedClass')) {
                if (!isset($config['types'][$typeName])) {
                    continue;
                }

                $this->logger->warning('The type "{type}" is deprecated', ['type' => $type->getUri()]);
            }

            $typeConfig = $config['types'][$typeName] ?? null;
            $class = $baseClass;

            $comment = $type->get('rdfs:comment');

            $class['name'] = $typeName;
            $class['label'] = $comment ? $comment->getValue() : '';
            $class['resource'] = $type;
            $class['config'] = $typeConfig;

            $class['isEnum'] = $this->isEnum($type);
            if ($class['isEnum']) {
                $class['namespace'] = $typeConfig['namespace'] ?? $config['namespaces']['enum'];
                $class['parent'] = 'Enum';
                $class['uses'][] = Enum::class;

                // Constants
                foreach ($this->graphs as $graph) {
                    foreach ($graph->allOfType($type->getUri()) as $instance) {
                        $class['constants'][$instance->localName()] = [
                            'name' => strtoupper(substr(preg_replace('/([A-Z])/', '_$1', $instance->localName()), 1)),
                            'resource' => $instance,
                            'value' => $instance->getUri(),
                        ];
                    }
                }
            } else {
                // Entities
                $class['namespace'] = $typeConfig['namespaces']['class'] ?? $config['namespaces']['entity'];

                // Parent
                $class['parent'] = $typeConfig['parent'] ?? null;
                if (null === $class['parent']) {
                    $numberOfSupertypes = \count($type->all('rdfs:subClassOf'));

                    if ($numberOfSupertypes > 1) {
                        $this->logger->warning(sprintf('The type "%s" has several supertypes. Using the first one.', $type->localName()));
                    }

                    $class['parent'] = $numberOfSupertypes ? $type->all('rdfs:subClassOf')[0]->localName() : false;
                }

                if (isset($class['parent'], $config['types'][$class['parent']]['namespaces']['class'])) {
                    $parentNamespace = $config['types'][$class['parent']]['namespaces']['class'];

                    if ($parentNamespace !== $class['namespace']) {
                        $class['uses'][] = $parentNamespace.'\\'.$class['parent'];
                    }
                }

                // Embeddable
                $class['embeddable'] = $typeConfig['embeddable'] ?? false;

                // Interfaces
                if ($config['useInterface']) {
                    $class['interfaceNamespace'] = isset($typeConfig['namespaces']['interface']) && $typeConfig['namespaces']['interface'] ? $typeConfig['namespaces']['interface'] : $config['namespaces']['interface'];
                    $class['interfaceName'] = sprintf('%sInterface', $typeName);
                }
            }

            // Fields
            if (!($typeConfig['allProperties'] ?? false) && \is_array($typeConfig['properties'] ?? null)) {
                foreach ($typeConfig['properties'] as $key => $value) {
                    foreach ($propertiesMap[$type->getUri()] as $property) {
                        if ($key !== $property->localName()) {
                            continue;
                        }

                        $class = $this->generateField($config, $class, $type, $typeName, $property);
                        continue 2;
                    }

                    // Add custom fields (not defined in the vocabulary)
                    $this->logger->info(sprintf('The property "%s" (type "%s") is a custom property.', $key, $type->getUri()));
                    $customResource = new Resource('_:'.$key, new Graph());
                    $customResource->add('rdfs:range', $type);
                    $class = $this->generateField($config, $class, $type, $typeName, $customResource);
                }
            } else {
                // All properties
                foreach ($propertiesMap[$type->getUri()] as $property) {
                    if ($property->hasProperty(self::SCHEMA_ORG_SUPERSEDED_BY)) {
                        $supersededBy = $property->get('schema:supersededBy');
                        $this->logger->warning(sprintf('The property "%s" is superseded by "%s". Using the superseding property.', $property->getUri(), $supersededBy->getUri()));
                    } else {
                        $class = $this->generateField($config, $class, $type, $typeName, $property);
                    }
                }
            }

            $classes[$typeName] = $class;
        }

        // Second pass
        foreach ($classes as &$class) {
            if ($class['parent']) {
                if (isset($classes[$class['parent']])) {
                    $classes[$class['parent']]['hasChild'] = true;
                    $class['parentHasConstructor'] = $classes[$class['parent']]['hasConstructor'];
                } else {
                    $this->logger->error(sprintf('The type "%s" (parent of "%s") doesn\'t exist', $class['parent'], $type->getUri()));
                }
            }

            foreach ($class['fields'] as &$field) {
                $rangeName = $field['range'] ? $field['range']->localName() : null;
                $field['isEnum'] = $classes[$rangeName]['isEnum'] ?? false;
                $field['typeHint'] = $this->phpTypeConverter->getPhpType($field, $config, $classes);

                if ($field['isArray']) {
                    $field['adderRemoverTypeHint'] = $this->phpTypeConverter->getPhpType(['isArray' => false] + $field, $config, $classes);
                }
            }
        }

        // Third pass
        foreach ($classes as &$class) {
            $class['abstract'] = $config['types'][$class['name']]['abstract'] ?? $class['hasChild'];

            // When including all properties, ignore properties already set on parent
            if (isset($config['types'][$class['name']]['allProperties'], $classes[$class['parent']]) && $config['types'][$class['name']]['allProperties']) {
                $type = $class['resource'];

                foreach ($propertiesMap[$type->getUri()] as $property) {
                    if (!isset($class['fields'][$property->localName()])) {
                        continue;
                    }

                    $parentConfig = $config['types'][$class['parent']] ?? null;
                    $parentClass = $classes[$class['parent']];

                    while ($parentClass) {
                        if (!isset($parentConfig['properties']) ||
                            !\is_array($parentConfig['properties']) ||
                            0 === \count($parentConfig['properties'])
                        ) {
                            // Unset implicit property
                            $parentType = $parentClass['resource'];
                            if (\in_array($property, $propertiesMap[$parentType->getUri()], true)) {
                                unset($class['fields'][$property->localName()]);
                                continue 2;
                            }
                        } else {
                            // Unset explicit property
                            if (\array_key_exists($property->localName(), $parentConfig['properties'])) {
                                unset($class['fields'][$property->localName()]);
                                continue 2;
                            }
                        }

                        $parentConfig = $parentClass['parent'] ? ($config['types'][$parentClass['parent']] ?? null) : null;
                        $parentClass = $parentClass['parent'] ? $classes[$parentClass['parent']] : null;
                    }
                }
            }
        }

        // Generate ID
        if ($config['id']['generate']) {
            foreach ($classes as &$class) {
                if ($class['hasChild'] || $class['isEnum'] || $class['embeddable']) {
                    continue;
                }

                switch ($config['id']['generationStrategy']) {
                    case 'auto':
                        $uri = 'http://schema.org/Integer';
                        $typeHint = 'int';
                        $writable = false;
                        $nullable = true;
                        break;
                    case 'uuid':
                        $uri = 'http://schema.org/Text';
                        $typeHint = 'string';
                        $writable = $config['id']['writable'];
                        $nullable = !$writable;
                        break;
                    case 'mongoid':
                        $uri = 'http://schema.org/Text';
                        $typeHint = 'string';
                        $writable = false;
                        $nullable = true;
                        break;
                    default:
                        $uri = 'http://schema.org/Text';
                        $typeHint = 'string';
                        $writable = true;
                        $nullable = false;
                        break;
                }

                $class['fields'] = [
                    'id' => [
                        'name' => 'id',
                        'resource' => null,
                        'range' => new Resource($uri),
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_1_1,
                        'ormColumn' => null,
                        'isArray' => false,
                        'isReadable' => true,
                        'isWritable' => $writable,
                        'isNullable' => $nullable,
                        'isUnique' => false,
                        'isCustom' => true,
                        'isEnum' => false,
                        'isId' => true,
                        'typeHint' => $typeHint,
                    ],
                ] + $class['fields'];
            }
        }

        // Initialize annotation generators
        $annotationGenerators = [];
        foreach ($config['annotationGenerators'] as $annotationGenerator) {
            $generator = new $annotationGenerator($this->phpTypeConverter, $this->logger, $this->inflector, $this->graphs, $this->cardinalities, $config, $classes);

            $annotationGenerators[] = $generator;
        }

        $interfaceMappings = [];
        $generatedFiles = [];

        foreach ($classes as $className => &$class) {
            $class['uses'] = $this->generateClassUses($annotationGenerators, $classes, $className);
            $class['annotations'] = $this->generateClassAnnotations($annotationGenerators, $className);
            if (false === isset($typesToGenerate[$className])) {
                $class['interfaceAnnotations'] = $this->generateInterfaceAnnotations($annotationGenerators, $className);
            }

            foreach ($class['constants'] as $constantName => $constant) {
                $class['constants'][$constantName]['annotations'] = $this->generateConstantAnnotations($annotationGenerators, $className, $constantName);
            }

            foreach ($class['fields'] as $fieldName => &$field) {
                $field['annotations'] = $this->generateFieldAnnotations($annotationGenerators, $className, $fieldName);
                $field['getterAnnotations'] = $this->generateGetterAnnotations($annotationGenerators, $className, $fieldName);

                if ($field['isArray']) {
                    $field['adderAnnotations'] = $this->generateAdderAnnotations($annotationGenerators, $className, $fieldName);
                    $field['removerAnnotations'] = $this->generateRemoverAnnotations($annotationGenerators, $className, $fieldName);
                } else {
                    $field['setterAnnotations'] = $this->generateSetterAnnotations($annotationGenerators, $className, $fieldName);
                }
            }

            $classDir = $this->namespaceToDir($config, $class['namespace']);
            $this->filesystem->mkdir($classDir);

            $path = sprintf('%s%s.php', $classDir, $className);
            $generatedFiles[] = $path;

            file_put_contents(
                $path,
                $this->twig->render('class.php.twig', [
                    'config' => $config,
                    'class' => $class,
                ])
            );

            if (isset($class['interfaceNamespace'])) {
                $interfaceDir = $this->namespaceToDir($config, $class['interfaceNamespace']);
                $this->filesystem->mkdir($interfaceDir);

                $path = sprintf('%s%s.php', $interfaceDir, $class['interfaceName']);
                $generatedFiles[] = $path;
                file_put_contents(
                    $path,
                    $this->twig->render('interface.php.twig', [
                        'config' => $config,
                        'class' => $class,
                    ])
                );

                if ($config['doctrine']['resolveTargetEntityConfigPath'] && !$class['abstract']) {
                    $interfaceMappings[$class['interfaceNamespace'].'\\'.$class['interfaceName']] = $class['namespace'].'\\'.$className;
                }
            }
        }

        if ($config['doctrine']['resolveTargetEntityConfigPath'] && \count($interfaceMappings) > 0) {
            $file = $config['output'].'/'.$config['doctrine']['resolveTargetEntityConfigPath'];
            $dir = \dirname($file);
            $this->filesystem->mkdir($dir);

            file_put_contents(
                $file,
                $this->twig->render('doctrine.xml.twig', ['mappings' => $interfaceMappings])
            );

            $generatedFiles[] = $file;
        }

        $this->fixCs($generatedFiles);
    }

    /**
     * Tests if a type is an enum.
     */
    private function isEnum(Resource $type): bool
    {
        $subClassOf = $type->get('rdfs:subClassOf');

        return $subClassOf && self::SCHEMA_ORG_ENUMERATION === $subClassOf->getUri();
    }

    /**
     * Gets the parent classes of the current one and add them to $parentClasses array.
     *
     * @param resource[] $parentClasses
     */
    private function getParentClasses(Resource $resource, array $parentClasses = []): array
    {
        if ([] === $parentClasses) {
            return $this->getParentClasses($resource, [$resource]);
        }

        if (!$subclasses = $resource->all('rdfs:subClassOf')) {
            return $parentClasses;
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

        return $parentClasses;
    }

    /**
     * Creates a map between classes and properties.
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
                'uris' => array_map(fn (Resource $parentClass) => $parentClass->getUri(), $parentClasses),
                'names' => array_map(fn (Resource $parentClass) => $parentClass->localName(), $parentClasses),
            ];
            $map[$type->getUri()] = [];
        }

        foreach ($this->graphs as $graph) {
            foreach (self::$propertyTypes as $propertyType) {
                foreach ($graph->allOfType($propertyType) as $property) {
                    if ($property->isBNode()) {
                        continue;
                    }

                    foreach (self::$domainProperties as $domainPropertyType) {
                        foreach ($property->all($domainPropertyType) as $domain) {
                            foreach ($typesResources as $typesResourceHierarchy) {
                                if (\in_array($domain->getUri(), $typesResourceHierarchy['uris'], true)) {
                                    $typeUri = $typesResourceHierarchy['uris'][0];
                                    if ($property->isA('owl:DeprecatedProperty')) {
                                        $propertyName = $property->localName();
                                        if (!isset($config['types'][$typesResourceHierarchy['names'][0]]['properties'][$propertyName])) {
                                            continue;
                                        }

                                        $this->logger->warning('The property "{property}" of the type "{type}" is deprecated', ['property' => $property->getUri(), 'type' => $typeUri]);
                                    }
                                    $map[$typeUri][] = $property;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $map;
    }

    /**
     * Updates generated $class with given field config.
     */
    private function generateField(array $config, array $class, Resource $type, string $typeName, Resource $property): array
    {
        $typeUri = $type->getUri();
        $propertyName = $property->localName();
        $propertyUri = $property->getUri();
        $typeConfig = $config['types'][$typeName] ?? null;
        $typesDefined = !empty($config['types']);

        // Warn when property are not part of GoodRelations
        if ($config['checkIsGoodRelations']) {
            if (!$this->goodRelationsBridge->exist($propertyName)) {
                $this->logger->warning(sprintf('The property "%s" (type "%s") is not part of GoodRelations.', $propertyUri, $typeUri));
            }
        }

        // Ignore or warn when properties are legacy
        if (null !== $property && preg_match('/legacy spelling/', (string) $property->get('rdfs:comment'))) {
            if (isset($typeConfig['properties'])) {
                $this->logger->warning(sprintf('The property "%s" (type "%s") is legacy.', $propertyUri, $typeUri));
            } else {
                $this->logger->info(sprintf('The property "%s" (type "%s") is legacy. Ignoring.', $propertyUri, $typeUri));

                return $class;
            }
        }

        $propertyConfig = $typeConfig['properties'][$propertyName] ?? [];

        $isCustom = true;
        $ranges = [];
        foreach (self::$rangeProperties as $rangePropertyType) {
            foreach ($property->all($rangePropertyType) as $range) {
                if (!$range instanceof Resource || $range->isBNode()) {
                    continue;
                }

                $localName = $range->localName();
                if (
                    (!isset($propertyConfig['range']) || $propertyConfig['range'] === $localName) &&
                    (!$typesDefined || isset($config['types'][$localName]) || $this->phpTypeConverter->isDatatype($range))
                ) {
                    $isCustom = false;
                    $ranges[] = $range;
                }
            }
        }

        $numberOfRanges = \count($ranges);
        if (0 === $numberOfRanges) {
            if (isset($propertyConfig['range'])) {
                $ranges[] = $property->get('rdf:Property');
            } else {
                $this->logger->error(sprintf('The property "%s" (type "%s") has an unknown type. Add its type to the config file.', $propertyUri, $typeUri));
            }
        } else {
            if ($numberOfRanges > 1) {
                $this->logger->warning(sprintf('The property "%s" (type "%s") has several types. Using the first one ("%s") or possible options("%s").', $propertyUri, $typeUri, $ranges[0]->getUri(), implode('", "', array_map(fn (Resource $range) => $range->getUri(), $ranges))));
            }

            $cardinality = $propertyConfig['cardinality'] ?? false;
            if (!$cardinality || CardinalitiesExtractor::CARDINALITY_UNKNOWN === $cardinality) {
                $cardinality = $this->cardinalities[$propertyName] ?? CardinalitiesExtractor::CARDINALITY_1_1;
            }
            // TODO: extract OWL cardinalities here

            $isArray = \in_array($cardinality, [
                CardinalitiesExtractor::CARDINALITY_0_N,
                CardinalitiesExtractor::CARDINALITY_1_N,
                CardinalitiesExtractor::CARDINALITY_N_N,
            ], true);

            if (isset($propertyConfig['nullable'])) {
                $isNullable = (bool) $propertyConfig['nullable'];
            } else {
                $isNullable = !\in_array($cardinality, [
                    CardinalitiesExtractor::CARDINALITY_1_1,
                    CardinalitiesExtractor::CARDINALITY_1_N,
                ], true);
            }

            $columnPrefix = false;
            $isEmbedded = $propertyConfig['embedded'] ?? false;

            if (true === $isEmbedded) {
                $columnPrefix = $propertyConfig['columnPrefix'] ?? false;
            }

            $class['fields'][$propertyName] = [
                'name' => $this->getFieldName($propertyName, $isArray),
                'resource' => $property,
                'range' => $ranges[0] ?? null,
                'cardinality' => $cardinality,
                'ormColumn' => $propertyConfig['ormColumn'] ?? null,
                'isArray' => $isArray,
                'isReadable' => $propertyConfig['readable'] ?? true,
                'isWritable' => $propertyConfig['writable'] ?? true,
                'isNullable' => $isNullable,
                'isUnique' => $propertyConfig['unique'] ?? false,
                'isCustom' => $isCustom,
                'isEmbedded' => $isEmbedded,
                'columnPrefix' => $columnPrefix,
                'mappedBy' => $propertyConfig['mappedBy'] ?? null,
                'inversedBy' => $propertyConfig['inversedBy'] ?? null,
                'isId' => false,
            ];

            if ($isArray) {
                $class['hasConstructor'] = true;

                if ($config['doctrine']['useCollection'] && !\in_array(ArrayCollection::class, $class['uses'], true)) {
                    $class['uses'][] = ArrayCollection::class;
                    $class['uses'][] = Collection::class;
                }
            }
        }

        return $class;
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateFieldAnnotations(array $annotationGenerators, string $className, string $fieldName): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateFieldAnnotations($className, $fieldName);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateConstantAnnotations(array $annotationGenerators, string $className, string $constantName): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateConstantAnnotations($className, $constantName);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateClassAnnotations(array $annotationGenerators, string $className): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateClassAnnotations($className);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateInterfaceAnnotations(array $annotationGenerators, string $className): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateInterfaceAnnotations($className);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateGetterAnnotations(array $annotationGenerators, string $className, string $fieldName): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateGetterAnnotations($className, $fieldName);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateAdderAnnotations(array $annotationGenerators, string $className, string $fieldName): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateAdderAnnotations($className, $fieldName);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateRemoverAnnotations(array $annotationGenerators, string $className, string $fieldName): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateRemoverAnnotations($className, $fieldName);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateSetterAnnotations(array $annotationGenerators, string $className, string $fieldName): array
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations[] = $generator->generateSetterAnnotations($className, $fieldName);
        }

        return array_merge(...$annotations);
    }

    /**
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     */
    private function generateClassUses(array $annotationGenerators, array $classes, string $className): array
    {
        $uses = $classes[$className]['uses'];

        if (isset($classes[$className]['interfaceNamespace'])
            && $classes[$className]['interfaceNamespace'] !== $classes[$className]['namespace']
        ) {
            $uses[] = sprintf(
                '%s\\%s',
                $classes[$className]['interfaceNamespace'],
                $classes[$className]['interfaceName']
            );
        }

        foreach ($classes[$className]['fields'] as $field) {
            $rangeName = $field['range'] ? $field['range']->localName() : null;
            if (isset($classes[$rangeName]['interfaceName'])) {
                $use = sprintf(
                    '%s\\%s',
                    $classes[$rangeName]['interfaceNamespace'],
                    $classes[$rangeName]['interfaceName']
                );

                if (!\in_array($use, $uses, true)) {
                    $uses[] = $use;
                }
            }
        }

        $newUses = [];
        foreach ($annotationGenerators as $generator) {
            $newUses[] = $generator->generateUses($className);
        }

        $uses = array_merge($uses, ...$newUses);

        // Order alphabetically
        sort($uses);

        return $uses;
    }

    /**
     * Converts a namespace to a directory path according to PSR-4.
     */
    private function namespaceToDir(array $config, string $namespace): string
    {
        if (null !== ($prefix = $config['namespaces']['prefix'] ?? null) && 0 === strpos($namespace, $prefix)) {
            $namespace = substr($namespace, \strlen($prefix));
        }

        return sprintf('%s/%s/', $config['output'], str_replace('\\', '/', $namespace));
    }

    /**
     * Uses PHP CS Fixer to make generated files following PSR and Symfony Coding Standards.
     */
    private function fixCs(array $files): void
    {
        $fileInfos = [];
        foreach ($files as $file) {
            $fileInfos[] = new \SplFileInfo($file);
        }

        $fixers = (new FixerFactory())
            ->registerBuiltInFixers()
            ->useRuleSet(new RuleSet([
                '@Symfony' => true,
                'array_syntax' => ['syntax' => 'short'],
                'phpdoc_order' => true,
                'declare_strict_types' => true,
            ]))
            ->getFixers();

        $runner = new Runner(
            new \ArrayIterator($fileInfos),
            $fixers,
            new NullDiffer(),
            null,
            new ErrorsManager(),
            new Linter(),
            false,
            new NullCacheManager()
        );
        $runner->fix();
    }

    private function getFieldName(string $propertyName, bool $isArray): string
    {
        $snakeProperty = preg_replace('/([A-Z])/', '_$1', $propertyName);
        $exploded = explode('_', $snakeProperty);

        if (2 < \strlen($word = $exploded[\count($exploded) - 1])) {
            $exploded[\count($exploded) - 1] = $isArray ? $this->inflector->pluralize($word) : $this->inflector->singularize($word);

            return implode('', $exploded);
        }

        return $propertyName;
    }
}
