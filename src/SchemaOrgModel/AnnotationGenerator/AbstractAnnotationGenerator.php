<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

use Psr\Log\LoggerInterface;

/**
 * Abstract annotation generator
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
abstract class AbstractAnnotationGenerator implements AnnotationGeneratorInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var \EasyRdf_Graph[]
     */
    protected $graphs;
    /**
     * @var array
     */
    protected $cardinalities;
    /**
     * @var array
     */
    protected $config;
    /**
     * @var array
     */
    protected $classes;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        LoggerInterface $logger,
        array $graphs,
        array $cardinalities,
        array $config,
        array $classes
    )
    {
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->cardinalities = $cardinalities;
        $this->config = $config;
        $this->classes = $classes;
    }

    /**
     * Converts a Schema.org range to a PHP type
     *
     * @param  string $range
     * @return string
     */
    protected function toPhpType($range)
    {
        switch ($range) {
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

        if (isset($this->classes[$range]['interfaceName'])) {
            return $this->classes[$range]['interfaceName'];
        }

        return $range;
    }
}
