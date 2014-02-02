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

        $this->baseClass = [
            'header' => $this->config['header'],
            'namespace' => $this->config['namespace'],
            'author' => $this->config['author'],
            'field_visibility' => $this->config['field_visibility']
        ];
    }

    /**
     * Generates files
     */
    public function generate()
    {
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

            if (count($type->supertypes) > 1) {
                // Ignore multiple inheritance for now
                $this->logger->notice(sprintf('The type %s has several supertypes. Using the first one.', $typeId));
            }

            $class = $this->baseClass;

            $class['label'] = $type->label;
            $class['link'] = $type->url;
            $class['name'] = $type->id;
            $class['parent'] = count($type->supertypes) ? $type->supertypes[0] : false;
            $class['fields'] = [];

            foreach ($type->specific_properties as $propertyId) {
                // Ignore properties not set in config file
                if (!empty($this->config['types'][$typeId]['properties']) && !in_array($propertyId, $this->config['types'][$typeId]['properties'])) {
                    continue;
                }

                $property = $this->schemaOrg->properties->$propertyId;
                if ($this->config['check_is_goodrelations']) {
                    if (!$this->goodRelationsBridge->exist($propertyId)) {
                        $this->logger->warning(sprintf('The property %s is not part of GoodRelations.', $propertyId));
                    }
                }

                // Ignore or warn when properties are legacy
                if (preg_match('/legacy spelling/', $property->comment)) {
                    if (empty($this->config['types'][$typeId]['properties'])) {
                        $this->logger->info(sprintf('The property %s is legacy. Ignoring.', $propertyId));

                        continue;
                    } else {
                        $this->logger->warning(sprintf('The property %s is legacy.', $propertyId));
                    }
                }

                $ranges = [];
                foreach ($property->ranges as $range) {
                    if (empty($this->config['types']) || $this->isDatatype($range) || !empty($this->config['types'][$range])) {
                        $ranges[] = $range;
                    }
                }

                $numberOfRanges = count($ranges);
                if ($numberOfRanges === 1) {
                    $class['fields'][] = [
                        'label' => $property->label,
                        'type' => self::toPhpType($ranges[0]),
                        'id' => $property->id,
                        'comment' => $property->comment
                    ];
                } elseif ($numberOfRanges > 1) {
                    $this->logger->warning(sprintf('The property %s has several types. This is currently not fully supported.', $propertyId));

                    foreach ($ranges as $range) {
                        $class['fields'][] = [
                            'label' => sprintf('%s (%s)', $property->label, $range),
                            'type' => self::toPhpType($range),
                            'id' => sprintf('%s%s', $property->id, $range),
                            'comment' => $property->comment
                        ];
                    }
                }
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
     * Converts a Schema.org type to a PHP type
     *
     * @param  string $type
     * @return string
     */
    private static function toPhpType($type)
    {
        switch ($type) {
            case 'Boolean':
                return 'boolean';
                break;
            case 'Date':
                // No break
            case 'DateTime':
                // No break
            case 'Time':
                return '\DateTime';
                break;
            case 'Number':
                // No break
            case 'Float':
                return 'float';
                break;
            case 'Integer':
                return 'integer';
                break;
            case 'Text':
                // No break
            case 'URL':
                return 'string';
                break;
        }

        return $type;
    }
}
