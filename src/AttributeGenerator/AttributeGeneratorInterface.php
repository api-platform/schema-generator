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

/**
 * Attribute Generator Interface.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AttributeGeneratorInterface
{
    /**
     * Generates class's attributes.
     *
     * @return array<string, array>[]
     */
    public function generateClassAttributes(Class_ $class): array;

    /**
     * Generates field's attributes.
     *
     * @return array<string, array>[]
     */
    public function generatePropertyAttributes(Property $property, string $className): array;

    /**
     * Generates uses.
     */
    public function generateUses(Class_ $class): array;
}
