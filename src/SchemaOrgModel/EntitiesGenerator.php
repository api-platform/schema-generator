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
class EntitiesGenerator
{
    /**
     * @var Twig_Environment
     */
    protected $twig;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var \stdClass
     */
    protected $schemaOrg;
    /**
     * @var CardinalitiesExtractor
     */
    protected $cardinalitiesExtractor;
    /**
     * @var GoodRelationsBridge
     */
    protected $goodRelationsBridge;
    /**
     * @var array
     */
    protected $config;
    /**
     * @var array
     */
    protected $annotationGenerators = [];
    /**
     * @var array
     */
    protected $cardinalities;

    /**
     * @param \Twig_Environment $twig
     * @param LoggerInterface $logger
     * @param \stdClass $schemaOrg
     * @param CardinalitiesExtractor $cardinalitiesExtractor
     * @param GoodRelationsBridge $goodRelationsBridge
     * @param array $config
     */
    public function __construct(
        \Twig_Environment $twig,
        LoggerInterface $logger,
        \stdClass $schemaOrg,
        CardinalitiesExtractor $cardinalitiesExtractor,
        GoodRelationsBridge $goodRelationsBridge,
        array $config = []
    )
    {
        $this->twig = $twig;
        $this->logger = $logger;
        $this->schemaOrg = $schemaOrg;
        $this->cardinalitiesExtractor = $cardinalitiesExtractor;
        $this->goodRelationsBridge = $goodRelationsBridge;
        $this->config = $config;

        $this->cardinalities = $this->cardinalitiesExtractor->extract();

        foreach ($config['annotationGenerators'] as $class) {
            $generator = new $class($logger, $schemaOrg, $this->cardinalities, $config);

            $this->annotationGenerators[] = $generator;
        }

        $this->baseClass = [
            'header' => $this->config['header'],
            'namespace' => $this->config['namespace'],
            'fieldVisibility' => $this->config['fieldVisibility'],
            'fields' => [],
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
            foreach ($this->schemaOrg->types as $type) {
                $typesToGenerate[] = $type->id;
            }
        } else {
            $typesToGenerate = array_keys($this->config['types']);
        }

        foreach ($typesToGenerate as $typeId) {
            $type = $this->schemaOrg->types->$typeId;
            $typeDefined = !empty($this->config['types'][$typeId]['properties']);

            $class = $this->baseClass;

            $class['label'] = $type->label;
            $class['name'] = $typeId;
            $class['uses'] = $this->generateUses($class['name']);
            $class['annotations'] = $this->generateClassAnnotations($class['name']);

            // Parent
            $class['parent'] = $typeDefined ? $this->config['types'][$typeId]['parent'] : null;
            if (null === $class['parent']) {
                $numberOfSupertypes = count($type->supertypes);

                if ($numberOfSupertypes > 1) {
                    $this->logger->error(sprintf('The type "%s" has several supertypes. Using the first one.', $typeId));
                }

                $class['parent'] = $numberOfSupertypes ? $type->supertypes[0] : false;
            }

            if ($typesDefined && $class['parent'] && !isset($this->config['types'][$class['parent']])) {
                $this->logger->error(sprintf('The type "%s" (parent of "%s") doesn\'t exist', $class['parent'], $class['name']));
            }

            // Fields
            foreach ($type->specific_properties as $propertyId) {
                // Ignore properties not set if using a config file
                if ($typesDefined && !isset($this->config['types'][$typeId]['properties'][$propertyId])) {
                    continue;
                }

                $property = $this->schemaOrg->properties->$propertyId;
                if ($this->config['checkIsGoodRelations']) {
                    if (!$this->goodRelationsBridge->exist($propertyId)) {
                        $this->logger->warning(sprintf('The property "%s" (type "%s") is not part of GoodRelations.', $propertyId, $typeId));
                    }
                }

                // Ignore or warn when properties are legacy
                if (preg_match('/legacy spelling/', $property->comment)) {
                    if (empty($this->config['types'][$typeId]['properties'])) {
                        $this->logger->info(sprintf('The property "%s" (type "%s") is legacy. Ignoring.', $propertyId, $typeId));

                        continue;
                    } else {
                        $this->logger->warning(sprintf('The property "%s" (type "%s") is legacy.', $propertyId, $typeId));
                    }
                }

                $ranges = [];
                if (isset($this->config['types'][$typeId]['properties'][$propertyId]['range']) && $this->config['types'][$typeId]['properties'][$propertyId]['range']) {
                    $ranges[] = $this->config['types'][$typeId]['properties'][$propertyId]['range'];
                } else {
                    foreach ($property->ranges as $range) {
                        if (!$typesDefined || $this->isDatatype($range) || !empty($this->config['types'][$range])) {
                            $ranges[] = $range;
                        }
                    }
                }

                $numberOfRanges = count($ranges);
                if ($numberOfRanges > 1) {
                    $this->logger->error(sprintf('The property "%s" (type "%s") has several types. Using the first one.', $propertyId, $typeId));
                }

                $class['fields'][] = [
                    'name' => $property->id,
                    'annotations' => $this->generateFieldAnnotations($class['name'], $property->id, $ranges[0])
                ];
            }

            file_put_contents(sprintf('%s/%s.php', $this->config['output'], $class['name']), $this->twig->render('class.php.twig', $class));
        }
    }

    /**
     * @deprecated
     * @param  array $types
     * @param  array $dependencies
     * @return array
     */
    private function getDependencies(array $types, array $dependencies = [])
    {
        foreach ($types as $type) {
            if (!in_array($type, $dependencies)) {
                $dependencies[] = $type;

                foreach ($this->schemaOrg->types->$type->properties as $property) {
                    foreach ($this->schemaOrg->properties->$property->ranges as $dependency) {
                        if (!in_array($dependency, $dependencies) && !isset ($this->schemaOrg->datatypes->$dependency)) {
                            $dependencies = self::getDependencies([$dependency], $dependencies);
                        }
                    }
                }
            }
        }

        return $dependencies;
    }

    /**
     * @deprecated
     * @param  array $types
     * @return bool
     */
    private static function isOnlyDatatype(array $types)
    {
        foreach ($types as $type) {
            if (!self::isDatatype($type)) {
                return false;
            }
        }

        return true;
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
     * Generates class annotations
     *
     * @param  string $className
     * @return array
     */
    private function generateClassAnnotations($className)
    {
        $annotations = [];
        foreach ($this->annotationGenerators as $generator) {
            $annotations = array_merge($annotations, $generator->generateClassAnnotations($className));
        }

        return $annotations;
    }

    /**
     * Generates uses
     *
     * @param  string $className
     * @return array
     */
    private function generateUses($className)
    {
        $uses = [];
        foreach ($this->annotationGenerators as $generator) {
            $uses = array_merge($uses, $generator->generateUses($className));
        }

        return $uses;
    }
}
