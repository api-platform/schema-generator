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
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use MyCLabs\Enum\Enum;

abstract class EnumClassMutator implements ClassMutatorInterface
{
    protected PhpTypeConverterInterface $phpTypeConverter;
    private string $desiredNamespace;

    public function __construct(PhpTypeConverterInterface $phpTypeConverter, string $desiredNamespace)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->desiredNamespace = $desiredNamespace;
    }

    /**
     * @param array{} $context
     */
    public function __invoke(Class_ $class, array $context): void
    {
        $class->namespace = $this->desiredNamespace;
        $class
            ->withParent('Enum')
            ->addUse(new Use_(Enum::class));

        $this->addEnumConstants($class);
    }

    abstract protected function addEnumConstants(Class_ $class): void;
}
