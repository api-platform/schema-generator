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
    public function __construct(LoggerInterface $logger, array $graphs, array $cardinalities, array $config, array $classes)
    {
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->cardinalities = $cardinalities;
        $this->config = $config;
        $this->classes = $classes;
    }

    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(string $className): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateInterfaceAnnotations(string $className): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations(string $className, string $constantName): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(string $className, string $fieldName): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateGetterAnnotations(string $className, string $fieldName): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateSetterAnnotations(string $className, string $fieldName): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateAdderAnnotations(string $className, string $fieldName): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateRemoverAnnotations(string $className, string $fieldName): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(string $className): array
    {
        return [];
    }

    /**
     * Converts a Schema.org range to a PHP type.
     */
    protected function toPhpType(array $field, bool $adderOrRemover = false): string
    {
        $range = $field['range'];

        if ($field['isEnum']) {
            if ($field['isArray']) {
                return 'string[]';
            }

            return 'string';
        }

        $data = false;
        switch ($range) {
            case 'Boolean':
                $data = 'bool';
                break;
            case 'Date':
            case 'DateTime':
            case 'Time':
                $data = '\\'.\DateTimeInterface::class;
                break;
            case 'Number':
            case 'Float':
                $data = 'float';
                break;
            case 'Integer':
                $data = 'integer';
                break;
            case 'Text':
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
                return sprintf('Collection<%s>', $range);
            }

            return sprintf('%s[]', $range);
        }

        return $range;
    }
}
