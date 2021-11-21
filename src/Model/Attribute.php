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

final class Attribute
{
    private string $name;

    /** @var (int|bool|null|string|string[]|string[][]|\Nette\PhpGenerator\Literal)[] */
    private array $args;

    /**
     * @param (int|bool|null|string|string[]|string[][]|\Nette\PhpGenerator\Literal)[] $args
     */
    public function __construct(string $name, array $args = [])
    {
        $this->name = $name;
        $this->args = $args;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return (int|bool|null|string|string[]|string[][]|\Nette\PhpGenerator\Literal)[]
     */
    public function args(): array
    {
        return $this->args;
    }
}
