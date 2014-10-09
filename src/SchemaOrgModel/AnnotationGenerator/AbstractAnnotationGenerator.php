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
     * {@inheritdoc}
     */
    public function __construct(LoggerInterface $logger, array $graphs, array $cardinalities, array $config)
    {
        $this->logger = $logger;
        $this->graphs = $graphs;
        $this->cardinalities = $cardinalities;
        $this->config = $config;
    }
}
