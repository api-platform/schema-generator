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
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Symfony Serializer Groups attribute generator.
 *
 * @author Youssef El Montaser <youssef@elmontaser.com>
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @see https://symfony.com/doc/master/components/serializer.html
 */
final class SerializerGroupsAttributeGenerator extends AbstractAttributeGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        if (false === $property->isId && $property->groups) {
            return [new Attribute('Groups', [$property->groups])];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        return [new Use_(Groups::class)];
    }
}
