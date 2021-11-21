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
use ApiPlatform\SchemaGenerator\PropertyGenerator\IdPropertyGenerator;

final class ClassIdAppender implements ClassMutatorInterface
{
    /** @var Configuration */
    private array $config;

    /**
     * @param Configuration $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __invoke(Class_ $class): Class_
    {
        if (
            $class->isEnum()
            || $class->isEmbeddable
            || ($class->hasParent() && 'parent' === $this->config['id']['onClass'])
            || ($class->hasChild && 'child' === $this->config['id']['onClass'])
        ) {
            return $class;
        }

        return $class->addProperty((new IdPropertyGenerator())($this->config['id']['generationStrategy'], $this->config['id']['writable']));
    }
}
