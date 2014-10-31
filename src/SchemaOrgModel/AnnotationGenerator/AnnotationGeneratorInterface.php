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
 * Annotation Generator Interface
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AnnotationGeneratorInterface
{
    /**
     * @param LoggerInterface  $logger
     * @param \EasyRdf_Graph[] $graphs
     * @param array            $cardinalities
     * @param array            $config
     * @param array            $classes
     */
    public function __construct(
        LoggerInterface $logger,
        array $graphs,
        array $cardinalities,
        array $config,
        array $classes
    );

    /**
     * Generates class' annotations
     *
     * @param  string $className
     * @return array
     */
    public function generateClassAnnotations($className);

    /**
     * Generates interface's annotations
     *
     * @param  string $className
     * @return array
     */
    public function generateInterfaceAnnotations($className);

    /**
     * Generates constant's annotations
     *
     * @param  string $className
     * @param  string $constantName
     * @return array
     */
    public function generateConstantAnnotations($className, $constantName);

    /**
     * Generates field's annotation
     *
     * @param  string $className
     * @param  string $fieldName
     * @return array
     */
    public function generateFieldAnnotations($className, $fieldName);

    /**
     * Generates uses
     *
     * @param  string $className
     * @return array
     */
    public function generateUses($className);
}
