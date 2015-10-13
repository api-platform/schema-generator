<?php

/*
 * (c) Sidney Curron <ceednee@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ApiPlatform\SchemaGenerator\NamespaceGenerator;

use Psr\Log\LoggerInterface;

/**
 * Namespace Generator Interface
 *
 * @author Sidney Curron <ceednee@restotelry.com>
 */
interface NamespaceGeneratorInterface
{
    /**
     * @param LoggerInterface $logger
     * @param array           $graphs
     * @param array           $cardinalities
     * @param array           $config
     * @param array           $classes
     */
    public function __construct(
        LoggerInterface $logger,
        array $graphs,
        array $cardinalities,
        array $config,
        array $classes
    );

    /**
     * Generates uses.
     *
     * @param string $className
     *
     * @return array
     */
    public function generateUses($className);
}
