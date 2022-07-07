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

use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AttributeGeneratorInterface
{
    /**
     * Generates class's attributes.
     *
     * @return Attribute[]
     */
    public function generateClassAttributes(Class_ $class): array;

    /**
     * Generates field's attributes.
     *
     * @return Attribute[]
     */
    public function generatePropertyAttributes(Property $property, string $className): array;

    /**
     * Generates class attributes once class and properties attributes for all classes have been generated.
     *
     * @return Attribute[]
     */
    public function generateLateClassAttributes(Class_ $class): array;

    /**
     * Generates uses.
     *
     * @return Use_[]
     */
    public function generateUses(Class_ $class): array;
}
