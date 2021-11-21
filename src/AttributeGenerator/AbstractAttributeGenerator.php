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

namespace ApiPlatform\SchemaGenerator\AttributeGenerator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use Doctrine\Inflector\Inflector;
use EasyRdf\Graph as RdfGraph;
use Psr\Log\LoggerInterface;

/**
 * Abstract attribute generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
abstract class AbstractAttributeGenerator implements AttributeGeneratorInterface
{
    protected PhpTypeConverterInterface $phpTypeConverter;
    protected Inflector $inflector;
    protected LoggerInterface $logger;
    /** @var RdfGraph[] */
    protected array $graphs;
    /** @var array<string, string> */
    protected array $cardinalities;
    /** @var Configuration */
    protected array $config;
    /** @var Class_[] */
    protected array $classes;

    /**
     * @param RdfGraph[]            $graphs
     * @param array<string, string> $cardinalities
     * @param Configuration         $config
     * @param Class_[]              $classes
     */
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
    public function generateClassAttributes(Class_ $class): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return [];
    }
}
