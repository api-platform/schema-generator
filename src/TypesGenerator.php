<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator;

use ApiPlatform\SchemaGenerator\AnnotationGenerator\AnnotationGeneratorInterface;
use Psr\Log\LoggerInterface;
use Symfony\CS\Config;
use Symfony\CS\ConfigurationResolver;
use Symfony\CS\Fixer;

/**
 * Entities generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class TypesGenerator
{
    /**
     * @var string
     *
     * @see https://github.com/myclabs/php-enum Used enum implementation
     */
    const ENUM_USE = 'MyCLabs\Enum\Enum';

    /**
     * @var string
     *
     * @see https://github.com/doctrine/collections
     */
    const DOCTRINE_COLLECTION_USE = 'Doctrine\Common\Collections\ArrayCollection';

    /**
     * @var string
     *
     * @see https://github.com/myclabs/php-enum Used enum implementation
     */
    const ENUM_EXTENDS = 'Enum';

    /**
     * @var string
     */
    const SCHEMA_ORG_NAMESPACE = 'http://schema.org/';

    /**
     * @var string
     */
    const SCHEMA_ORG_ENUMERATION = 'http://schema.org/Enumeration';

    /**
     * @var string
     */
    const SCHEMA_ORG_DOMAIN = 'schema:domainIncludes';

    /**
     * @var string
     */
    const SCHEMA_ORG_RANGE = 'schema:rangeIncludes';

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \EasyRdf_Graph[]
     */
    private $graphs;

    /**
     * @var CardinalitiesExtractor
     */
    private $cardinalitiesExtractor;

    /**
     * @var GoodRelationsBridge
     */
    private $goodRelationsBridge;

    /**
     * @var array
     */
    private $cardinalities;

    /**
     * @param \Twig_Environment      $twig
     * @param LoggerInterface        $logger
     * @param \EasyRdf_Graph[]       $graphs
     * @param CardinalitiesExtractor $cardinalitiesExtractor
     * @param GoodRelationsBridge    $goodRelationsBridge
     */
    public function __construct(\Twig_Environment $twig, LoggerInterface $logger, array $graphs, CardinalitiesExtractor $cardinalitiesExtractor, GoodRelationsBridge $goodRelationsBridge)
    {
        if (empty($graphs)) {
            throw new \InvalidArgumentException('At least one graph must be injected.');
        }

        $this->twig = $twig;
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->cardinalitiesExtractor = $cardinalitiesExtractor;
        $this->goodRelationsBridge = $goodRelationsBridge;

        $this->cardinalities = $this->cardinalitiesExtractor->extract();
    }

    /**
     * Generates files.
     *
     * @param array $config
     */
    public function generate(array $config)
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

        if (empty($config['types'])) {
            foreach ($this->graphs as $graph) {
                $typesToGenerate = $graph->allOfType('rdfs:Class');
            }
        } else {
            foreach ($config['types'] as $typeName => $typeConfig) {
                $resource = null;
                foreach ($this->graphs as $graph) {
                    $resources = $graph->resources();

                    if (isset($resources[$typeConfig['vocabularyNamespace'].$typeName])) {
                        $resource = $graph->resource($typeConfig['vocabularyNamespace'].$typeName, 'rdfs:Class');
                        break;
                    }
                }

                if ($resource) {
                    $typesToGenerate[$typeName] = $resource;
                } else {
                    $this->logger->warning('Type "{typeName}" cannot be found. Using "{guessFrom}" type to generate entity.', ['typeName' => $typeName, 'guessFrom' => $typeConfig['guessFrom']]);
                    $type = $graph->resource($typeConfig['vocabularyNamespace'].$typeConfig['guessFrom'], 'rdfs:Class');
                    $typesToGenerate[$typeName] = $type;
                }
            }
        }

        $classes = [];
        $propertiesMap = $this->createPropertiesMap($typesToGenerate);

        foreach ($typesToGenerate as $typeName => $type) {
            $typeName = is_string($typeName) ? $typeName : $type->localName();
            $typeConfig = isset($config['types'][$typeName]) ? $config['types'][$typeName] : null;
            $class = $baseClass;

            $comment = $type->get('rdfs:comment');

            $class['name'] = $typeName;
            $class['label'] = $comment ? $comment->getValue() : '';
            $class['resource'] = $type;
            $class['config'] = $typeConfig;

            $class['isEnum'] = $this->isEnum($type);
            if ($class['isEnum']) {
                $class['namespace'] = isset($typeConfig['namespace']) ? $typeConfig['namespace'] : $config['namespaces']['enum'];
                $class['parent'] = self::ENUM_EXTENDS;
                $class['uses'][] = self::ENUM_USE;

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
                $class['namespace'] = isset($typeConfig['namespaces']['class']) ? $typeConfig['namespaces']['class'] : $config['namespaces']['entity'];

                // Parent
                $class['parent'] = isset($typeConfig['parent']) ? $typeConfig['parent'] : null;
                if (null === $class['parent']) {
                    $numberOfSupertypes = count($type->all('rdfs:subClassOf'));

                    if ($numberOfSupertypes > 1) {
                        $this->logger->warning(sprintf('The type "%s" has several supertypes. Using the first one.', $type->localName()));
                    }

                    $class['parent'] = $numberOfSupertypes ? $type->all('rdfs:subClassOf')[0]->localName() : false;
                }

                if (isset($class['parent']) && isset($config['types'][$class['parent']]['namespaces']['class'])) {
                    $parentNamespace = $config['types'][$class['parent']]['namespaces']['class'];

                    if ($parentNamespace !== $class['namespace']) {
                        $class['uses'][] = $parentNamespace.'\\'.$class['parent'];
                    }
                }

                // Embeddable
                $class['embeddable'] = isset($typeConfig['embeddable']) ? $typeConfig['embeddable'] : false;

                if (!empty($config['types']) && $class['parent'] && !isset($config['types'][$class['parent']])) {
                    $this->logger->error(sprintf('The type "%s" (parent of "%s") doesn\'t exist', $class['parent'], $type->localName()));
                }

                // Interfaces
                if ($config['useInterface']) {
                    $class['interfaceNamespace'] = isset($typeConfig['namespaces']['interface']) && $typeConfig['namespaces']['interface'] ? $typeConfig['namespaces']['interface'] : $config['namespaces']['interface'];
                    $class['interfaceName'] = sprintf('%sInterface', $typeName);
                }
            }

            // Fields
            if (!$typeConfig['allProperties'] && isset($typeConfig['properties']) && is_array($typeConfig['properties'])) {
                foreach ($typeConfig['properties'] as $key => $value) {
                    foreach ($propertiesMap[$type->getUri()] as $property) {
                        if ($key !== $property->localName()) {
                            continue;
                        }

                        $class = $this->generateField($config, $class, $type, $typeName, $property->localName(), $property);
                        continue 2;
                    }

                    // Add custom fields (non schema.org)
                    $this->logger->info(sprintf('The property "%s" (type "%s") is a custom property.', $key, $type->localName()));
                    $class = $this->generateField($config, $class, $type, $typeName, $key);
                }
            } else {
                // All properties
                foreach ($propertiesMap[$type->getUri()] as $property) {
                    $class = $this->generateField($config, $class, $type, $typeName, $property->localName(), $property);
                }
            }

            $classes[$typeName] = $class;
        }

        // Second pass
        foreach ($classes as &$class) {
            if ($class['parent'] && isset($classes[$class['parent']])) {
                $classes[$class['parent']]['hasChild'] = true;
                $class['parentHasConstructor'] = $classes[$class['parent']]['hasConstructor'];
            }

            foreach ($class['fields'] as &$field) {
                $field['isEnum'] = isset($classes[$field['range']]) && $classes[$field['range']]['isEnum'];
            }
        }

        // Third pass
        foreach ($classes as &$class) {
            if (isset($config['types'][$class['name']]['abstract']) && null !== $config['types'][$class['name']]['abstract']) {
                $class['abstract'] = $config['types'][$class['name']]['abstract'];
            } else {
                $class['abstract'] = $class['hasChild'];
            }

            // When including all properties, ignore properties already set on parent
            if (isset($config['types'][$class['name']]['allProperties']) && $config['types'][$class['name']]['allProperties'] && isset($classes[$class['parent']])) {
                $type = $class['resource'];

                foreach ($propertiesMap[$type->getUri()] as $property) {
                    if (!isset($class['fields'][$property->localName()])) {
                        continue;
                    }

                    $parentConfig = isset($config['types'][$class['parent']]) ? $config['types'][$class['parent']] : null;
                    $parentClass = $classes[$class['parent']];

                    while ($parentClass) {
                        if (!isset($parentConfig['properties']) || !is_array($parentConfig['properties'])) {
                            // Unset implicit property
                            $parentType = $parentClass['resource'];
                            if (in_array($property, $propertiesMap[$parentType->getUri()])) {
                                unset($class['fields'][$property->localName()]);
                                continue 2;
                            }
                        } else {
                            // Unset explicit property
                            if (array_key_exists($property->localName(), $parentConfig['properties'])) {
                                unset($class['fields'][$property->localName()]);
                                continue 2;
                            }
                        }

                        $parentConfig = $parentClass['parent'] ? (isset($config['types'][$parentClass['parent']]) ? $config['types'][$parentClass['parent']] : null) : null;
                        $parentClass = $parentClass['parent'] ? $classes[$parentClass['parent']] : null;
                    }
                }
            }
        }

        // Generate ID
        if ($config['generateId']) {
            foreach ($classes as &$class) {
                if (!$class['hasChild'] && !$class['isEnum'] && !$class['embeddable']) {
                    $class['fields'] = [
                        'id' => [
                            'name' => 'id',
                            'resource' => null,
                            'range' => 'Integer',
                            'cardinality' => CardinalitiesExtractor::CARDINALITY_1_1,
                            'ormColumn' => null,
                            'isArray' => false,
                            'isNullable' => false,
                            'isUnique' => false,
                            'isCustom' => true,
                            'isEnum' => false,
                            'isId' => true,
                        ],
                    ] + $class['fields'];
                }
            }
        }

        // Initialize annotation generators
        $annotationGenerators = [];
        foreach ($config['annotationGenerators'] as $annotationGenerator) {
            $generator = new $annotationGenerator($this->logger, $this->graphs, $this->cardinalities, $config, $classes);

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
                $typeHint = false;
                if ($this->isDateTime($field['range'])) {
                    $typeHint = '\\DateTime';
                } elseif (!($this->isDatatype($field['range']) || $field['isEnum'])) {
                    if (isset($classes[$field['range']]['interfaceName'])) {
                        $typeHint = $classes[$field['range']]['interfaceName'];
                    } else {
                        $typeHint = $classes[$field['range']]['name'];
                    }
                }

                $field['typeHint'] = $typeHint;
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

            if (!file_exists($classDir)) {
                mkdir($classDir, 0777, true);
            }

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

                if (!file_exists($interfaceDir)) {
                    mkdir($interfaceDir, 0777, true);
                }

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

        if (!empty($interfaceMappings) && $config['doctrine']['resolveTargetEntityConfigPath']) {
            $file = $config['output'].'/'.$config['doctrine']['resolveTargetEntityConfigPath'];
            $dir = dirname($file);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

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
     *
     * @param \EasyRdf_Resource $type
     *
     * @return bool
     */
    private function isEnum(\EasyRdf_Resource $type)
    {
        $subClassOf = $type->get('rdfs:subClassOf');

        return $subClassOf && $subClassOf->getUri() === self::SCHEMA_ORG_ENUMERATION;
    }

    /**
     * Gets the parent classes of the current one and add them to $parentClasses array.
     *
     * @param \EasyRdf_Resource $resource
     * @param string[]          $parentClasses
     *
     * @return array
     */
    private function getParentClasses(\EasyRdf_Resource $resource, array $parentClasses = [])
    {
        if ([] === $parentClasses) {
            return $this->getParentClasses($resource, [$resource->getUri()]);
        }

        $subclasses = $resource->all('rdfs:subClassOf');

        if (empty($subclasses)) {
            return $parentClasses;
        }

        $parentClass = $subclasses[0];
        $parentClasses[] = $parentClass->getUri();

        foreach ($this->graphs as $graph) {
            foreach ($graph->allOfType('rdfs:Class') as $type) {
                if ($type->getUri() === $parentClass->getUri()) {
                    $parentClasses = $this->getParentClasses($type, $parentClasses);

                    break 2;
                }
            }
        }

        return $parentClasses;
    }

    /**
     * Creates a map between classes and properties.
     *
     * @param array $types
     *
     * @return array
     */
    private function createPropertiesMap(array $types)
    {
        $typesAsString = [];
        $map = [];
        foreach ($types as $type) {
            // get all parent classes until the root
            $parentClasses = $this->getParentClasses($type);
            $typesAsString[] = $parentClasses;
            $map[$type->getUri()] = [];
        }

        foreach ($this->graphs as $graph) {
            foreach ($graph->allOfType('rdf:Property') as $property) {
                foreach ($property->all(self::SCHEMA_ORG_DOMAIN) as $domain) {
                    foreach ($typesAsString as $typesAsStringItem) {
                        if (in_array($domain->getUri(), $typesAsStringItem)) {
                            $map[$typesAsStringItem[0]][] = $property;
                        }
                    }
                }
            }
        }

        return $map;
    }

    /**
     * Is this type a datatype?
     *
     * @param string $type
     *
     * @return bool
     */
    private function isDatatype($type)
    {
        return in_array($type, ['Boolean', 'DataType', 'Date', 'DateTime', 'Float', 'Integer', 'Number', 'Text', 'Time', 'URL']);
    }

    /**
     * Is this type a \DateTime?
     *
     * @param $type
     *
     * @return bool
     */
    private function isDateTime($type)
    {
        return in_array($type, ['Date', 'DateTime', 'Time']);
    }

    /**
     * Updates generated $class with given field config.
     *
     * @param array                  $config
     * @param array                  $class
     * @param \EasyRdf_Resource      $type
     * @param string                 $typeName
     * @param string                 $propertyName
     * @param \EasyRdf_Resource|null $property
     *
     * @return array $class
     */
    private function generateField(array $config, array $class, \EasyRdf_Resource $type, $typeName, $propertyName, \EasyRdf_Resource $property = null)
    {
        $typeConfig = isset($config['types'][$typeName]) ? $config['types'][$typeName] : null;
        $typesDefined = !empty($config['types']);

        // Warn when property are not part of GoodRelations
        if ($config['checkIsGoodRelations']) {
            if (!$this->goodRelationsBridge->exist($propertyName)) {
                $this->logger->warning(sprintf('The property "%s" (type "%s") is not part of GoodRelations.', $propertyName, $type->localName()));
            }
        }

        // Ignore or warn when properties are legacy
        if (!empty($property) && preg_match('/legacy spelling/', $property->get('rdfs:comment'))) {
            if (isset($typeConfig['properties'])) {
                $this->logger->warning(sprintf('The property "%s" (type "%s") is legacy.', $propertyName, $type->localName()));
            } else {
                $this->logger->info(sprintf('The property "%s" (type "%s") is legacy. Ignoring.', $propertyName, $type->localName()));

                return $class;
            }
        }

        $propertyConfig = isset($typeConfig['properties'][$propertyName]) ? $typeConfig['properties'][$propertyName] : null;

        $ranges = [];
        if (isset($propertyConfig['range']) && $propertyConfig['range']) {
            $ranges[] = $propertyConfig['range'];
        } elseif (!empty($property)) {
            foreach ($property->all(self::SCHEMA_ORG_RANGE) as $range) {
                if (!$typesDefined || $this->isDatatype($range->localName()) || isset($config['types'][$range->localName()])) {
                    $ranges[] = $range->localName();
                }
            }
        }

        $numberOfRanges = count($ranges);
        if (0 === $numberOfRanges) {
            $this->logger->error(sprintf('The property "%s" (type "%s") has an unknown type. Add its type to the config file.', $propertyName, $type->localName()));
        } else {
            if ($numberOfRanges > 1) {
                $this->logger->warning(sprintf('The property "%s" (type "%s") has several types. Using the first one.', $propertyName, $type->localName()));
            }

            $cardinality = isset($propertyConfig['cardinality']) ? $propertyConfig['cardinality'] : false;
            if (!$cardinality || $cardinality === CardinalitiesExtractor::CARDINALITY_UNKNOWN) {
                $cardinality = $property ? $this->cardinalities[$propertyName] : CardinalitiesExtractor::CARDINALITY_1_1;
            }

            $ormColumn = isset($propertyConfig['ormColumn']) ? $propertyConfig['ormColumn'] : null;

            $isArray = in_array($cardinality, [
                CardinalitiesExtractor::CARDINALITY_1_N,
                CardinalitiesExtractor::CARDINALITY_N_N,
            ]);

            if (isset($propertyConfig['nullable']) && false === $propertyConfig['nullable']) {
                $isNullable = false;
            } else {
                $isNullable = !in_array($cardinality, [
                    CardinalitiesExtractor::CARDINALITY_1_1,
                    CardinalitiesExtractor::CARDINALITY_1_N,
                ]);
            }

            $columnPrefix = false;
            $isEmbedded = isset($propertyConfig['embedded']) ? $propertyConfig['embedded'] : false;

            if (true === $isEmbedded) {
                $columnPrefix = isset($propertyConfig['columnPrefix']) ? $propertyConfig['columnPrefix'] : false;
            }

            $class['fields'][$propertyName] = [
                'name' => $propertyName,
                'resource' => $property,
                'range' => $ranges[0],
                'cardinality' => $cardinality,
                'ormColumn' => $ormColumn,
                'isArray' => $isArray,
                'isNullable' => $isNullable,
                'isUnique' => isset($propertyConfig['unique']) && $propertyConfig['unique'],
                'isCustom' => empty($property),
                'isEmbedded' => $isEmbedded,
                'columnPrefix' => $columnPrefix,
                'isId' => false,
            ];
            if ($isArray) {
                $class['hasConstructor'] = true;

                if ($config['doctrine']['useCollection'] && !in_array(self::DOCTRINE_COLLECTION_USE, $class['uses'])) {
                    $class['uses'][] = self::DOCTRINE_COLLECTION_USE;
                }
            }
        }

        return $class;
    }

    /**
     * Generates field's annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     * @param string                         $fieldName
     *
     * @return array
     */
    private function generateFieldAnnotations($annotationGenerators, $className, $fieldName)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateFieldAnnotations($className, $fieldName));
        }

        return $annotations;
    }

    /**
     * Generates constant's annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     * @param string                         $constantName
     *
     * @return array
     */
    private function generateConstantAnnotations(array $annotationGenerators, $className, $constantName)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateConstantAnnotations($className, $constantName));
        }

        return $annotations;
    }

    /**
     * Generates class' annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     *
     * @return array
     */
    private function generateClassAnnotations(array $annotationGenerators, $className)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateClassAnnotations($className));
        }

        return $annotations;
    }

    /**
     * Generates interface's annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     *
     * @return array
     */
    private function generateInterfaceAnnotations(array $annotationGenerators, $className)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateInterfaceAnnotations($className));
        }

        return $annotations;
    }

    /**
     * Generates getter's annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     * @param string                         $fieldName
     *
     * @return array
     */
    private function generateGetterAnnotations(array $annotationGenerators, $className, $fieldName)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateGetterAnnotations($className, $fieldName));
        }

        return $annotations;
    }

    /**
     * Generates adder's annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     * @param string                         $fieldName
     *
     * @return array
     */
    private function generateAdderAnnotations(array $annotationGenerators, $className, $fieldName)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateAdderAnnotations($className, $fieldName));
        }

        return $annotations;
    }

    /**
     * Generates remover's annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     * @param string                         $fieldName
     *
     * @return array
     */
    private function generateRemoverAnnotations(array $annotationGenerators, $className, $fieldName)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateRemoverAnnotations($className, $fieldName));
        }

        return $annotations;
    }

    /**
     * Generates getter's annotations.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                         $className
     * @param string                         $fieldName
     *
     * @return array
     */
    private function generateSetterAnnotations(array $annotationGenerators, $className, $fieldName)
    {
        $annotations = [];
        foreach ($annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateSetterAnnotations($className, $fieldName));
        }

        return $annotations;
    }

    /**
     * Generates uses.
     *
     * @param AnnotationGeneratorInterface[] $annotationGenerators
     * @param array                          $classes
     * @param string                         $className
     *
     * @return array
     */
    private function generateClassUses($annotationGenerators, $classes, $className)
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
            if (isset($classes[$field['range']]['interfaceName'])) {
                $use = sprintf(
                    '%s\\%s',
                    $classes[$field['range']]['interfaceNamespace'],
                    $classes[$field['range']]['interfaceName']
                );

                if (!in_array($use, $uses)) {
                    $uses[] = $use;
                }
            }
        }

        foreach ($annotationGenerators as $generator) {
            $uses = array_merge($uses, $generator->generateUses($className));
        }

        // Order alphabetically
        sort($uses);

        return $uses;
    }

    /**
     * Converts a namespace to a directory path according to PSR-4.
     *
     * @param array  $config
     * @param string $namespace
     *
     * @return string
     */
    private function namespaceToDir($config, $namespace)
    {
        return sprintf('%s/%s/', $config['output'], strtr($namespace, '\\', '/'));
    }

    /**
     * Uses PHP CS Fixer to make generated files following PSR and Symfony Coding Standards.
     *
     * @param array $files
     */
    private function fixCs(array $files)
    {
        $config = new Config();
        $fixer = new Fixer();
        $fixer->registerBuiltInConfigs();
        $fixer->registerBuiltInFixers();

        $resolver = new ConfigurationResolver();
        $resolver
            ->setAllFixers($fixer->getFixers())
            ->setConfig($config)
            ->setOptions([
                'level' => 'symfony',
                'fixers' => null,
                'progress' => false,
            ])
            ->resolve();

        $config->fixers($resolver->getFixers());

        $finder = [];
        foreach ($files as $file) {
            $finder[] = new \SplFileInfo($file);
        }

        $config->finder(new \ArrayIterator($finder));
        $fixer->fix($config);
    }
}
