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
use ApiPlatform\SchemaGenerator\Model\Use_;

/**
 * Annotation Generator Interface.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AnnotationGeneratorInterface
{
    /**
     * Generates class's annotations.
     *
     * @return string[]
     */
    public function generateClassAnnotations(Class_ $class): array;

    /**
     * Generates interface's annotations.
     *
     * @return string[]
     */
    public function generateInterfaceAnnotations(Class_ $class): array;

    /**
     * Generates constant's annotations.
     *
     * @return string[]
     */
    public function generateConstantAnnotations(Constant $constant): array;

    /**
     * Generates field's annotation.
     *
     * @return string[]
     */
    public function generatePropertyAnnotations(Property $property, string $className): array;

    /**
     * Generates getter's annotation.
     *
     * @return string[]
     */
    public function generateGetterAnnotations(Property $property): array;

    /**
     * Generates setter's annotation.
     *
     * @return string[]
     */
    public function generateSetterAnnotations(Property $property): array;

    /**
     * Generates adder's annotation.
     *
     * @return string[]
     */
    public function generateAdderAnnotations(Property $property): array;

    /**
     * Generates remover's annotation.
     *
     * @return string[]
     */
    public function generateRemoverAnnotations(Property $property): array;

    /**
     * Generates uses.
     *
     * @return Use_[]
     */
    public function generateUses(Class_ $class): array;
}
