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

namespace ApiPlatform\SchemaGenerator\Schema\Model\Type;

use ApiPlatform\SchemaGenerator\Model\Type\Type;

final class PrimitiveType implements Type
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getPhp(): string
    {
        switch ($this->name) {
            case 'integer':
            case 'negativeInteger':
            case 'nonNegativeInteger':
            case 'positiveInteger':
            case 'nonPositiveInteger':
            case 'byte':
                return 'int';
            case 'boolean':
                return 'bool';
            case 'float':
            case 'double':
            case 'decimal':
                return 'float';
            case 'date':
            case 'dateTime':
            case 'time':
                return '\\'.\DateTimeInterface::class;
            case 'duration':
                return '\\'.\DateInterval::class;
            case 'mixed':
                return '';
            default:
                return 'string';
        }
    }
}
