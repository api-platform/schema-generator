<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel;

use Psr\Log\LoggerInterface;

/**
 * Entities generator
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class TypesGenerator
{
    /**
     * @type string
     * @see https://github.com/myclabs/php-enum Used enum implementation
     */
    const ENUM_USE = 'MyCLabs\Enum\Enum';
    /**
     * @type string
     * @see https://github.com/myclabs/php-enum Used enum implementation
     */
    const ENUM_EXTENDS = 'Enum';
    /**
     * @type string
     */
    const SCHEMA_ORG_NAMESPACE = 'http://schema.org/';
    /**
     * @type string
     */
    const SCHEMA_ORG_ENUMERATION = 'http://schema.org/Enumeration';
    /**
     * @type string
     */
    const SCHEMA_ORG_DOMAIN = 'schema:domainIncludes';
    /**
     * @type string
     */
    const SCHEMA_ORG_RANGE = 'schema:rangeIncludes';

    /**
     * @type Twig_Environment
     */
    private $twig;
    /**
     * @type LoggerInterface
     */
    private $logger;
    /**
     * @type \EasyRdf_Graph[]
     */
    private $graphs;
    /**
     * @type CardinalitiesExtractor
     */
    private $cardinalitiesExtractor;
    /**
     * @type GoodRelationsBridge
     */
    private $goodRelationsBridge;
    /**
     * @type array
     */
    private $config;
    /**
     * @type array
     */
    private $annotationGenerators = [];
    /**
     * @type array
     */
    private $cardinalities;
    /**
     * @type array
     */
    private $baseClass;
    /**
     * @type array
     */
    private $baseInterface;

    /**
     * @param \Twig_Environment      $twig
     * @param LoggerInterface        $logger
     * @param \EasyRdf_Graph[]       $graphs
     * @param CardinalitiesExtractor $cardinalitiesExtractor
     * @param GoodRelationsBridge    $goodRelationsBridge
     * @param array                  $config
     */
    public function __construct(
        \Twig_Environment $twig,
        LoggerInterface $logger,
        array $graphs,
        CardinalitiesExtractor $cardinalitiesExtractor,
        GoodRelationsBridge $goodRelationsBridge,
        array $config = []
    )
    {
        $this->twig = $twig;
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->cardinalitiesExtractor = $cardinalitiesExtractor;
        $this->goodRelationsBridge = $goodRelationsBridge;
        $this->config = $config;

        $this->cardinalities = $this->cardinalitiesExtractor->extract();

        foreach ($config['annotationGenerators'] as $class) {
            $generator = new $class($logger, $graphs, $this->cardinalities, $config);

            $this->annotationGenerators[] = $generator;
        }

        $this->baseClass = [
            'header' => $this->config['header'],
            'fieldVisibility' => $this->config['fieldVisibility'],
            'constants' => [],
            'fields' => [],
            'uses' => [],
            'interface' => false
        ];

        $this->baseInterface = [
            'header' => $this->config['header'],
            'namespace' => $this->config['namespaces']['interface'],
            'uses' => []
        ];
    }

    /**
     * Generates files
     */
    public function generate()
    {
        $typesDefined = !empty($this->config['types']);
        $typesToGenerate = [];

        if (empty($this->config['types'])) {
            foreach ($this->graphs as $graph) {
                $typesToGenerate = $graph->allOfType('rdfs:Class');
            }
        } else {
            foreach ($this->config['types'] as $key => $value) {
                $resource = null;
                foreach ($this->graphs as $graph) {
                    $resources = $graph->resources();

                    if (isset($resources[self::SCHEMA_ORG_NAMESPACE.$key])) {
                        $resource = $graph->resource(self::SCHEMA_ORG_NAMESPACE . $key, 'rdfs:Class');
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

        $propertiesMap = $this->createPropertiesMap($typesToGenerate);

        foreach ($typesToGenerate as $type) {
            $typeDefined = !empty($this->config['types'][$type->localName()]['properties']);
            if ($typeDefined) {
                $config = $this->config['types'][$type->localName()];
            }
            $typeIsEnum = $this->isEnum($type);

            $class = $this->baseClass;
            $interface = $this->baseInterface;

            $interface['name'] = sprintf('%sInterface', $type->localName());

            $class['label'] = $type->get('rdfs:comment')->getValue();
            $class['name'] = $type->localName();
            $class['uses'] = $this->generateClassUses($type);
            $class['annotations'] = $this->generateClassAnnotations($type);

            if ($typeIsEnum) {
                // Enum
                $class['namespace'] = $typeDefined && $config['namespace'] ? $config['namespace'] : $this->config['namespaces']['enum'];
                $class['parent'] = self::ENUM_EXTENDS;
                $class['uses'][] = self::ENUM_USE;

                // Constants
                foreach ($this->graphs as $graph) {
                    foreach ($graph->allOfType($type->getUri()) as $instance) {
                        $underscoredName = strtoupper(substr(preg_replace('/([A-Z])/', '_$1', $instance->localName()), 1));
                        $class['constants'][] = [
                            'name' => $underscoredName,
                            'value' => $instance->getUri(),
                            'annotations' => $this->generateConstantAnnotations($type, $instance, $underscoredName)
                        ];
                    }
                }
            } else {
                // Entities
                $class['namespace'] = $this->config['namespaces']['entity'];

                if ($this->config['useRte']) {
                    $class['interface'] = $interface;
                }

                // Parent
                $class['parent'] = $typeDefined ? $config['parent'] : null;
                if (null === $class['parent']) {
                    $numberOfSupertypes = count($type->all('rdfs:subClassOf'));

                    if ($numberOfSupertypes > 1) {
                        $this->logger->error(sprintf('The type "%s" has several supertypes. Using the first one.', $type->localName()));
                    }

                    $class['parent'] = $numberOfSupertypes ? $type->all('rdfs:subClassOf')[0]->localName() : false;
                }

                if ($typesDefined && $class['parent'] && !isset($this->config['types'][$class['parent']])) {
                    $this->logger->error(sprintf('The type "%s" (parent of "%s") doesn\'t exist', $class['parent'], $class['name']));
                }
            }

            // Fields
            foreach ($propertiesMap[$type->getUri()] as $property) {
                // Ignore properties not set if using a config file
                if ($typeDefined && !isset($config['properties'][$property->localName()])) {
                    continue;
                }

                if ($this->config['checkIsGoodRelations']) {
                    if (!$this->goodRelationsBridge->exist($property->localName())) {
                        $this->logger->warning(sprintf('The property "%s" (type "%s") is not part of GoodRelations.', $property->localName(), $type->localName()));
                    }
                }

                // Ignore or warn when properties are legacy
                if (preg_match('/legacy spelling/', $property->get('rdfs:comment'))) {
                    if (empty($config['properties'])) {
                        $this->logger->info(sprintf('The property "%s" (type "%s") is legacy. Ignoring.', $property->localName(), $type->localName()));

                        continue;
                    } else {
                        $this->logger->warning(sprintf('The property "%s" (type "%s") is legacy.', $property->localName(), $type->localName()));
                    }
                }

                $ranges = [];
                if (isset($config['properties'][$property->localName()]['range']) && $config['properties'][$property->localName()]['range']) {
                    $ranges[] = $config['properties'][$property->localName()]['range'];
                } else {
                    foreach ($property->all(self::SCHEMA_ORG_RANGE) as $range) {
                        if (!$typesDefined || $this->isDatatype($range->localName()) || !empty($this->config['types'][$range->localName()])) {
                            // Force enums to Text
                            $ranges[] = $this->isEnum($range) ? 'Text' : $range->localName();
                        }
                    }
                }

                $numberOfRanges = count($ranges);
                if ($numberOfRanges > 1) {
                    $this->logger->error(sprintf('The property "%s" (type "%s") has several types. Using the first one.', $property->localName(), $type->localName()));
                }

                $class['fields'][] = [
                    'name' => $property->localName(),
                    'annotations' => $this->generateFieldAnnotations($type, $property, $ranges[0])
                ];
            }

            $dir = sprintf('%s/%s/', $this->config['output'], strtr($class['namespace'], '\\', '/'));

            // Creates directories for PSR-0 compliance
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            file_put_contents(sprintf('%s%s.php', $dir, $class['name']), $this->twig->render('class.php.twig', $class));
        }
    }

    /**
     * Tests if a type is an enum
     *
     * @param  \EasyRdf_Resource $type
     * @return bool
     */
    private function isEnum(\EasyRdf_Resource $type)
    {
        $subClassOf = $type->get('rdfs:subClassOf');

        return $subClassOf && $subClassOf->getUri() === self::SCHEMA_ORG_ENUMERATION;
    }

    /**
     * Create a maps between class an properties
     *
     * @param  array $types
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
     * @param  string $type
     * @return bool
     */
    private static function isDatatype($type)
    {
        return in_array($type, ['Boolean', 'DataType', 'Date', 'DateTime', 'Float', 'Integer', 'Number', 'Text', 'Time', 'URL']);
    }

    /**
     * Generates field's annotations
     *
     * @param  string $className
     * @param  string $fieldName
     * @param  string $range
     * @return array
     */
    private function generateFieldAnnotations($className, $fieldName, $range)
    {
        $annotations = [];
        foreach ($this->annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateFieldAnnotations($className, $fieldName, $range));
        }

        return $annotations;
    }

    /**
     * Generates constant annotations
     *
     * @param  \EasyRdf_Resource $class
     * @param  \EasyRdf_Resource $instance
     * @param  string            $name
     * @return array
     */
    private function generateConstantAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $instance, $name)
    {
        $annotations = [];
        foreach ($this->annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateConstantAnnotations($class, $instance, $name));
        }

        return $annotations;
    }

    /**
     * Generates class annotations
     *
     * @param  \EasyRdf_Resource $class
     * @return array
     */
    private function generateClassAnnotations(\EasyRdf_Resource $class)
    {
        $annotations = [];
        foreach ($this->annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateClassAnnotations($class));
        }

        return $annotations;
    }

    /**
     * Generates uses
     *
     * @param  \EasyRdf_Resource $class
     * @return array
     */
    private function generateClassUses(\EasyRdf_Resource $class)
    {
        $uses = [];
        foreach ($this->annotationGenerators as $generator) {
            $uses = array_merge($uses, $generator->generateUses($class));
        }

        return $uses;
    }
}
