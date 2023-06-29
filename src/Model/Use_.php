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

namespace ApiPlatform\SchemaGenerator\Model;

final class Use_
{
    private string $name;

    private ?string $alias;

    public function __construct(string $name, string $alias = null)
    {
        $this->name = $name;
        $this->alias = $alias;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function alias(): ?string
    {
        return $this->alias;
    }
}
