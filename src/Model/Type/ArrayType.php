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

final class ArrayType implements Type
{
    public ?Type $type;

    public function __construct(Type $type = null)
    {
        $this->type = $type;
    }

    public function __toString(): string
    {
        if ($this->type instanceof CompositeType) {
            return '('.$this->type.')[]';
        }

        return $this->type ? $this->type.'[]' : 'array';
    }

    public function getPhp(): string
    {
        if ($this->type instanceof CompositeType) {
            return '('.$this->type.')[]';
        }

        return $this->type ? $this->type.'[]' : 'array';
    }
}
