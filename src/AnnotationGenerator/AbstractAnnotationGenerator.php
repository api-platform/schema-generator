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

use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use Doctrine\Inflector\Inflector;
use EasyRdf\Graph;
use Psr\Log\LoggerInterface;

/**
 * Abstract annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
abstract class AbstractAnnotationGenerator implements AnnotationGeneratorInterface
{
    protected PhpTypeConverterInterface $phpTypeConverter;
    protected Inflector $inflector;
    protected LoggerInterface $logger;
    /**
     * @var Graph[]
     */
    protected array $graphs;
    protected array $cardinalities;
    protected array $config;
    protected array $classes;

    public function __construct(PhpTypeConverterInterface $phpTypeConverter, LoggerInterface $logger, Inflector $inflector, array $graphs, array $cardinalities, array $config, array $classes)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->inflector = $inflector;
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
}
