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
 * Annotation Generator Interface.
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
     * Generates class' annotations.
     *
     * @param string $className
     *
     * @return array
     */
    public function generateClassAnnotations($className);

    /**
     * Generates interface's annotations.
     *
     * @param string $className
     *
     * @return array
     */
    public function generateInterfaceAnnotations($className);

    /**
     * Generates constant's annotations.
     *
     * @param string $className
     * @param string $constantName
     *
     * @return array
     */
    public function generateConstantAnnotations($className, $constantName);

    /**
     * Generates field's annotation.
     *
     * @param string $className
     * @param string $fieldName
     *
     * @return array
     */
    public function generateFieldAnnotations($className, $fieldName);

    /**
     * Generates getter's annotation.
     *
     * @param string $className
     * @param string $fieldName
     *
     * @return array
     */
    public function generateGetterAnnotations($className, $fieldName);

    /**
     * Generates setter's annotation.
     *
     * @param string $className
     * @param string $fieldName
     *
     * @return array
     */
    public function generateSetterAnnotations($className, $fieldName);

    /**
     * Generates adder's annotation.
     *
     * @param string $className
     * @param string $fieldName
     *
     * @return array
     */
    public function generateAdderAnnotations($className, $fieldName);

    /**
     * Generates remover's annotation.
     *
     * @param string $className
     * @param string $fieldName
     *
     * @return array
     */
    public function generateRemoverAnnotations($className, $fieldName);

    /**
     * Generates uses.
     *
     * @param string $className
     *
     * @return array
     */
    public function generateUses($className);
}
