<?php

namespace ApiPlatform\SchemaGenerator\NamespaceGenerator;

use Psr\Log\LoggerInterface;

/**
 * Namespace Generator
 *
 * @author Sidney Curron <ceednee@gmail.com>
 */
abstract class AbstractNamespaceGenerator implements NamespaceGeneratorInterface
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
    public function generateUses($className)
    {
        return [];
    }
}

