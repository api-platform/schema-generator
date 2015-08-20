<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel;

use Psr\Log\LoggerInterface;
use Symfony\CS\Config\Config;
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
    public function __construct(
        \Twig_Environment $twig,
        LoggerInterface $logger,
        array $graphs,
        CardinalitiesExtractor $cardinalitiesExtractor,
        GoodRelationsBridge $goodRelationsBridge
    ) {
        $this->twig = $twig;
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->cardinalitiesExtractor = $cardinalitiesExtractor;
        $this->goodRelationsBridge = $goodRelationsBridge;

        $this->cardinalities = $this->cardinalitiesExtractor->extract();
    }

    /**
     * Generates files.
     */
    public function generate($config)
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

        $typesDefined = !empty($config['types']);
        $typesToGenerate = [];

        if (empty($config['types'])) {
            foreach ($this->graphs as $graph) {
                $typesToGenerate = $graph->allOfType('rdfs:Class');
            }
        } else {
            foreach ($config['types'] as $key => $value) {
                $resource = null;
                foreach ($this->graphs as $graph) {
                    $resources = $graph->resources();

                    if (isset($resources[self::SCHEMA_ORG_NAMESPACE.$key])) {
                        $resource = $graph->resource(self::SCHEMA_ORG_NAMESPACE.$key, 'rdfs:Class');
                        break;
                    }
                }

                if ($resource) {
                    $typesToGenerate[] = $resource;
                } else {
                    $this->logger->critical('Type "{key}" cannot be found.', ['key' => $key]);
                }
            }
        }

        $classes = [];
        $propertiesMap = $this->createPropertiesMap($typesToGenerate);

        foreach ($typesToGenerate as $type) {
            $typeConfig = isset($config['types'][$type->localName()]) ? $config['types'][$type->localName()] : null;
            $class = $baseClass;

            $class['name'] = $type->localName();
            $class['label'] = $type->get('rdfs:comment')->getValue();
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
                        $this->logger->error(sprintf('The type "%s" has several supertypes. Using the first one.', $type->localName()));
                    }

                    $class['parent'] = $numberOfSupertypes ? $type->all('rdfs:subClassOf')[0]->localName() : false;
                }

                if ($typesDefined && $class['parent'] && !isset($config['types'][$class['parent']])) {
                    $this->logger->error(sprintf('The type "%s" (parent of "%s") doesn\'t exist', $class['parent'], $type->localName()));
                }

                // Interfaces
                if ($config['useInterface']) {
                    $class['interfaceNamespace'] = isset($typeConfig['namespaces']['interface']) && $typeConfig['namespaces']['interface'] ? $typeConfig['namespaces']['interface'] : $config['namespaces']['interface'];
                    $class['interfaceName'] = sprintf('%sInterface', $type->localName());
                }
            }

            // Fields
            foreach ($propertiesMap[$type->getUri()] as $property) {
                // Ignore properties not set if using a config file
                if (is_array($typeConfig['properties']) && !isset($typeConfig['properties'][$property->localName()])) {
                    continue;
                }

                // Warn when property are not part of GoodRelations
                if ($config['checkIsGoodRelations']) {
                    if (!$this->goodRelationsBridge->exist($property->localName())) {
                        $this->logger->warning(sprintf('The property "%s" (type "%s") is not part of GoodRelations.', $property->localName(), $type->localName()));
                    }
                }

                // Ignore or warn when properties are legacy
                if (preg_match('/legacy spelling/', $property->get('rdfs:comment'))) {
                    if (isset($typeConfig['properties'])) {
                        $this->logger->warning(sprintf('The property "%s" (type "%s") is legacy.', $property->localName(), $type->localName()));
                    } else {
                        $this->logger->info(sprintf('The property "%s" (type "%s") is legacy. Ignoring.', $property->localName(), $type->localName()));
                        continue;
                    }
                }

                $ranges = [];
                if (isset($typeConfig['properties'][$property->localName()]['range']) && $typeConfig['properties'][$property->localName()]['range']) {
                    $ranges[] = $typeConfig['properties'][$property->localName()]['range'];
                } else {
                    foreach ($property->all(self::SCHEMA_ORG_RANGE) as $range) {
                        if (!$typesDefined || $this->isDatatype($range->localName()) || isset($config['types'][$range->localName()])) {
                            $ranges[] = $range->localName();
                        }
                    }
                }

                $numberOfRanges = count($ranges);
                if ($numberOfRanges === 0) {
                    $this->logger->error(sprintf('The property "%s" (type "%s") has an unknown type. Add its type to the config file.', $property->localName(), $type->localName()));
                } else {
                    if ($numberOfRanges > 1) {
                        $this->logger->error(sprintf('The property "%s" (type "%s") has several types. Using the first one.', $property->localName(), $type->localName()));
                    }

                    $cardinality = isset($typeConfig['properties'][$property->localName()]['cardinality']) ? $typeConfig['properties'][$property->localName()]['cardinality'] : false;
                    if (!$cardinality || $cardinality === CardinalitiesExtractor::CARDINALITY_UNKNOWN) {
                        $cardinality = $this->cardinalities[$property->localName()];
                    }

                    $isArray = in_array($cardinality, [
                        CardinalitiesExtractor::CARDINALITY_0_N,
                        CardinalitiesExtractor::CARDINALITY_1_N,
                        CardinalitiesExtractor::CARDINALITY_N_N,
                    ]);
                    $isNullable = !in_array($cardinality, [
                        CardinalitiesExtractor::CARDINALITY_1_1,
                        CardinalitiesExtractor::CARDINALITY_1_N,
                    ]);

                    $class['fields'][$property->localName()] = [
                        'name' => $property->localName(),
                        'resource' => $property,
                        'range' => $ranges[0],
                        'cardinality' => $cardinality,
                        'isArray' => $isArray,
                        'isNullable' => $isNullable,
                        'isId' => false,
                    ];
                    if ($isArray) {
                        $class['hasConstructor'] = true;

                        if ($config['doctrine']['useCollection'] && !in_array(self::DOCTRINE_COLLECTION_USE, $class['uses'])) {
                            $class['uses'][] = self::DOCTRINE_COLLECTION_USE;
                        }
                    }
                }
            }

            $classes[$type->localName()] = $class;
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
        }

        // Generate ID
        if ($config['generateId']) {
            foreach ($classes as &$class) {
                if (!$class['hasChild'] && !$class['isEnum']) {
                    $class['fields'] = [
                        'id' => [
                            'name' => 'id',
                            'resource' => null,
                            'range' => 'Integer',
                            'cardinality' => CardinalitiesExtractor::CARDINALITY_1_1,
                            'isArray' => false,
                            'isNullable' => false,
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

        if (isset($class['interfaceNamespace']) && $config['doctrine']['resolveTargetEntityConfigPath']) {
            $interfaceMappings = [];
        }

        $generatedFiles = [];
        foreach ($classes as $className => &$class) {
            $class['uses'] = $this->generateClassUses($annotationGenerators, $classes, $className);
            $class['annotations'] = $this->generateClassAnnotations($annotationGenerators, $className);
            $class['interfaceAnnotations'] = $this->generateInterfaceAnnotations($annotationGenerators, $className);

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

        if (isset($interfaceMappings) && $config['doctrine']['resolveTargetEntityConfigPath']) {
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
     * Create a maps between class an properties.
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
            $typesAsString[] = $type->getUri();
            $map[$type->getUri()] = [];
        }

        foreach ($this->graphs as $graph) {
            foreach ($graph->allOfType('rdf:Property') as $property) {
                foreach ($property->all(self::SCHEMA_ORG_DOMAIN) as $domain) {
                    if (in_array($domain->getUri(), $typesAsString)) {
                        $map[$domain->getUri()][] = $property;
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
     * Generates field's annotations.
     *
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
     * @param string                                                             $fieldName
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
     * @param string                                                             $constantName
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
     * @param string                                                             $fieldName
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
     * @param string                                                             $fieldName
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
     * @param string                                                             $fieldName
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param string                                                             $className
     * @param string                                                             $fieldName
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
     * @param \SchemaOrgModel\AnnotationGenerator\AnnotationGeneratorInterface[] $annotationGenerators
     * @param array                                                              $classes
     * @param string                                                             $className
     *
     * @return array
     */
    private function generateClassUses($annotationGenerators, $classes, $className)
    {
        $uses = $classes[$className]['uses'];

        if (
            isset($classes[$className]['interfaceNamespace'])
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
            ->setOptions(array(
                'level' => 'symfony',
                'fixers' => null,
                'progress' => false,
            ))
            ->resolve()
        ;

        $config->fixers($resolver->getFixers());

        $finder = [];
        foreach ($files as $file) {
            $finder[] = new \SplFileInfo($file);
        }

        $config->finder(new \ArrayIterator($finder));
        $fixer->fix($config);
    }
}
