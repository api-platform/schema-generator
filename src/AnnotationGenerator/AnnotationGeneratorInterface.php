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
 * Annotation Generator Interface.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AnnotationGeneratorInterface
{
    /**
     * @param \EasyRdf_Graph[] $graphs
     */
    public function __construct(LoggerInterface $logger, array $graphs, array $cardinalities, array $config, array $classes);

    /**
     * Generates class's annotations.
     */
    public function generateClassAnnotations(string $className): array;

    /**
     * Generates interface's annotations.
     */
    public function generateInterfaceAnnotations(string $className): array;

    /**
     * Generates constant's annotations.
     */
    public function generateConstantAnnotations(string $className, string $constantName): array;

    /**
     * Generates field's annotation.
     */
    public function generateFieldAnnotations(string $className, string $fieldName): array;

    /**
     * Generates getter's annotation.
     */
    public function generateGetterAnnotations(string $className, string $fieldName): array;

    /**
     * Generates setter's annotation.
     */
    public function generateSetterAnnotations(string $className, string $fieldName): array;

    /**
     * Generates adder's annotation.
     */
    public function generateAdderAnnotations(string $className, string $fieldName): array;

    /**
     * Generates remover's annotation.
     */
    public function generateRemoverAnnotations(string $className, string $fieldName): array;

    /**
     * Generates uses.
     */
    public function generateUses(string $className): array;
}
