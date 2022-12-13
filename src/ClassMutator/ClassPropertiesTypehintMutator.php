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
use ApiPlatform\SchemaGenerator\Model\Type\ArrayType;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;

final class ClassPropertiesTypehintMutator implements ClassMutatorInterface
{
    /** @var Class_[] */
    private array $classes;
    private PhpTypeConverterInterface $phpTypeConverter;
    /** @var Configuration */
    private array $config;

    /**
     * @param Configuration $config
     * @param Class_[]      $classes
     */
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, array $config, array $classes)
    {
        $this->classes = $classes;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->config = $config;
    }

    /**
     * @param array{} $context
     */
    public function __invoke(Class_ $class, array $context): void
    {
        foreach ($class->properties() as $property) {
            $property->isEnum = $property->isEnum ?: $property->reference && $property->reference->isEnum();
            $property->typeHint = $this->phpTypeConverter->getPhpType(
                $property,
                $this->config,
                $this->classes
            );

            if ($property->type instanceof ArrayType) {
                $nonArrayForcedProperty = clone $property;
                $nonArrayForcedProperty->type = $property->type->type;

                $property->adderRemoverTypeHint = $this->phpTypeConverter->getPhpType($nonArrayForcedProperty, $this->config, $this->classes);
            }
        }
    }
}
