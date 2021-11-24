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

use Nette\PhpGenerator\PhpNamespace;

/**
 * BC layer for the resolveName method of PhpNamespace.
 */
trait ResolveNameTrait
{
    private function resolveName(PhpNamespace $namespace, string $name): string
    {
        if (method_exists(PhpNamespace::class, 'resolveName')) {
            return $namespace->resolveName($name);
        }

        return $name;
    }
}
