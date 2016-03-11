<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use Psr\Log\LoggerInterface;

/**
 * Abstract annotation generator.
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
    ) {
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->cardinalities = $cardinalities;
        $this->config = $config;
        $this->classes = $classes;
    }

    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateInterfaceAnnotations($className)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations($className, $constantName)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateGetterAnnotations($className, $fieldName)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateSetterAnnotations($className, $fieldName)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateAdderAnnotations($className, $fieldName)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateRemoverAnnotations($className, $fieldName)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        return [];
    }

    /**
     * Converts a Schema.org range to a PHP type.
     *
     * @param array $field
     * @param bool  $adderOrRemover
     *
     * @return string
     */
    protected function toPhpType(array $field, $adderOrRemover = false)
    {
        $range = $field['range'];

        if ($field['isEnum']) {
            if ($field['isArray']) {
                return 'string[]';
            } else {
                return 'string';
            }
        }

        $data = false;
        switch ($range) {
            case 'Boolean':
                $data = 'boolean';
                break;
            case 'Date':
                // No break
            case 'DateTime':
                // No break
            case 'Time':
                $data = '\DateTime';
                break;
            case 'Number':
                // No break
            case 'Float':
                $data = 'float';
                break;
            case 'Integer':
                $data = 'integer';
                break;
            case 'Text':
                // No break
            case 'URL':
                $data = 'string';
                break;
        }

        if (false !== $data) {
            if ($field['isArray']) {
                return sprintf('%s[]', $data);
            }

            return $data;
        }

        if (isset($this->classes[$field['range']]['interfaceName'])) {
            $range = $this->classes[$field['range']]['interfaceName'];
        }

        if ($field['isArray'] && !$adderOrRemover) {
            if ($this->config['doctrine']['useCollection']) {
                return sprintf('ArrayCollection<%s>', $range);
            }

            return sprintf('%s[]', $range);
        }

        return $range;
    }
}
