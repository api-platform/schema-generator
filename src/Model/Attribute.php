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

use Nette\PhpGenerator\Attribute as NetteAttribute;
use Nette\PhpGenerator\PhpNamespace;

final class Attribute
{
    use ResolveNameTrait;

    private string $name;

    /** @var (int|bool|string|string[]|string[][]|\Nette\PhpGenerator\Literal|\Nette\PhpGenerator\Literal[]|null)[] */
    private array $args;

    /**
     * If this attribute can be appended if a same one has not previously been generated or if the same one is not mergeable?
     *
     * @see \ApiPlatform\SchemaGenerator\Model\AddAttributeTrait
     */
    public bool $append = true;

    /**
     * If this attribute mergeable with the next one?
     *
     * @see \ApiPlatform\SchemaGenerator\Model\AddAttributeTrait
     */
    public bool $mergeable = true;

    /**
     * @param (int|bool|string|string[]|string[][]|\Nette\PhpGenerator\Literal|\Nette\PhpGenerator\Literal[]|null)[] $args
     */
    public function __construct(string $name, array $args = [])
    {
        $this->name = $name;

        $this->append = (bool) ($args['alwaysGenerate'] ?? true);
        $this->mergeable = (bool) ($args['mergeable'] ?? true);

        unset($args['alwaysGenerate'], $args['mergeable']);

        $this->args = $args;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return (int|bool|string|string[]|string[][]|\Nette\PhpGenerator\Literal|\Nette\PhpGenerator\Literal[]|null)[]
     */
    public function args(): array
    {
        return $this->args;
    }

    public function toNetteAttribute(PhpNamespace $namespace): NetteAttribute
    {
        return new NetteAttribute($this->resolveName($namespace, $this->name), $this->args);
    }
}
