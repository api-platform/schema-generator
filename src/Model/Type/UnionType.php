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

namespace ApiPlatform\SchemaGenerator\Model\Type;

final class UnionType implements CompositeType
{
    /** @var Type[] */
    public array $types;

    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    public function __toString(): string
    {
        return implode('|', array_map(fn (Type $type) => $type instanceof CompositeType ? '('.$type.')' : $type, $this->types));
    }

    public function getPhp(): string
    {
        // Deduplicate PHP types.
        $phpTypes = [];
        foreach ($this->types as $type) {
            $phpTypes[$type->getPhp()] = $type;
        }

        return implode('|', array_map(fn (Type $type) => $type instanceof CompositeType ? '('.$type->getPhp().')' : $type->getPhp(), $phpTypes));
    }
}
