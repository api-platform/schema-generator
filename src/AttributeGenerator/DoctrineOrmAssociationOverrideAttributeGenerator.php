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
use Nette\PhpGenerator\Literal;

final class DoctrineOrmAssociationOverrideAttributeGenerator extends AbstractAttributeGenerator
{
    use GenerateIdentifierNameTrait;

    public function generateLateClassAttributes(Class_ $class): array
    {
        if ($class->isAbstract || !($parentName = $class->parent())) {
            return [];
        }

        $attributes = [];
        $associationOverrides = [];

        while ($parentName) {
            $parent = $this->classes[$parentName] ?? null;
            if (!$parent || !$parent->isAbstract) {
                $parentName = null;

                continue;
            }

            foreach ($parent->properties() as $property) {
                if ((
                    $joinTableAttribute = $property->getAttributeWithName('ORM\JoinTable'))
                    && \is_string($joinTableName = $joinTableAttribute->args()['name'])) {
                    $overrideJoinTableName = $this->generateIdentifierName($joinTableName.$class->name(), 'join_table', $this->config);
                    $overrideArgs = [
                        'name' => $property->name(),
                        'joinTable' => new Literal("new ORM\JoinTable(...?:)", [['name' => $overrideJoinTableName]]),
                    ];

                    $joinColumnAttribute = $property->getAttributeWithName('ORM\JoinColumn');
                    $overrideArgs['joinColumns'] = [new Literal("new ORM\JoinColumn(...?:)", [$joinColumnAttribute ? $joinColumnAttribute->args() : []])];

                    $inverseJoinColumnAttribute = $property->getAttributeWithName('ORM\InverseJoinColumn');
                    $overrideArgs['inverseJoinColumns'] = [new Literal("new ORM\InverseJoinColumn(...?:)", [$inverseJoinColumnAttribute ? $inverseJoinColumnAttribute->args() : []])];

                    $associationOverrides[] = new Literal(
                        "new ORM\AssociationOverride(...?:)",
                        [$overrideArgs]
                    );
                }
            }

            $parentName = $parent->parent();
        }

        if ($associationOverrides) {
            $attributes[] = new Attribute('ORM\AssociationOverrides', [$associationOverrides]);
        }

        return $attributes;
    }
}
