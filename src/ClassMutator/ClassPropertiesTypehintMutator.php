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
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;

final class ClassPropertiesTypehintMutator implements ClassMutatorInterface
{
    /** @var Class_[]|array */
    private array $classes;
    private PhpTypeConverterInterface $phpTypeConverter;
    private array $config;

    /**
     * @param Class_[]|array $classes
     */
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, array $config, array $classes)
    {
        $this->classes = $classes;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->config = $config;
    }

    public function __invoke(Class_ $class): Class_
    {
        foreach ($class->properties() as $property) {
            $property->isEnum = isset($this->classes[$property->rangeName]) ? ($this->classes[$property->rangeName])->isEnum() : false;
            $property->typeHint = $this->phpTypeConverter->getPhpType(
                $property,
                $this->config,
                $this->classes
            );

            if ($property->isArray) {
                $nonArrayForcedProperty = clone $property;
                $nonArrayForcedProperty->isArray = false;

                $property->adderRemoverTypeHint = $this->phpTypeConverter->getPhpType($nonArrayForcedProperty, $this->config, $this->classes);
            }
        }

        return $class;
    }
}
