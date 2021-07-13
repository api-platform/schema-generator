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

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Constant;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use Doctrine\Inflector\Inflector;
use Psr\Log\LoggerInterface;

/**
 * Annotation Generator Interface.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AnnotationGeneratorInterface
{
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, LoggerInterface $logger, Inflector $inflector, array $graphs, array $cardinalities, array $config, array $classes);

    /**
     * Generates class's annotations.
     */
    public function generateClassAnnotations(Class_ $class): array;

    /**
     * Generates interface's annotations.
     */
    public function generateInterfaceAnnotations(Class_ $class): array;

    /**
     * Generates constant's annotations.
     */
    public function generateConstantAnnotations(Constant $constant): array;

    /**
     * Generates field's annotation.
     */
    public function generatePropertyAnnotations(Property $property, string $className): array;

    /**
     * Generates getter's annotation.
     */
    public function generateGetterAnnotations(Property $property): array;

    /**
     * Generates setter's annotation.
     */
    public function generateSetterAnnotations(Property $property): array;

    /**
     * Generates adder's annotation.
     */
    public function generateAdderAnnotations(Property $property): array;

    /**
     * Generates remover's annotation.
     */
    public function generateRemoverAnnotations(Property $property): array;

    /**
     * Generates uses.
     */
    public function generateUses(Class_ $class): array;
}
