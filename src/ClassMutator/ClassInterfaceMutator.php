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

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Interface_;

final class ClassInterfaceMutator implements ClassMutatorInterface
{
    private string $desiredNamespace;

    public function __construct(string $desiredNamespace)
    {
        $this->desiredNamespace = $desiredNamespace;
    }

    /**
     * @param array{} $context
     */
    public function __invoke(Class_ $class, array $context): void
    {
        $class->interface = new Interface_(sprintf('%sInterface', $class->name()), $this->desiredNamespace);
    }
}
