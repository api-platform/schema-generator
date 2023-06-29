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

namespace ApiPlatform\SchemaGenerator\AttributeGenerator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\String\Inflector\InflectorInterface;

/**
 * Abstract attribute generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
abstract class AbstractAttributeGenerator implements AttributeGeneratorInterface
{
    use LoggerAwareTrait;

    protected PhpTypeConverterInterface $phpTypeConverter;
    protected InflectorInterface $inflector;
    /** @var Configuration */
    protected array $config;
    /** @var Class_[] */
    protected array $classes;

    /**
     * @param Configuration $config
     * @param Class_[]      $classes
     */
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, InflectorInterface $inflector, array $config, array $classes)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->inflector = $inflector;
        $this->config = $config;
        $this->classes = $classes;
    }

    public function generateClassAttributes(Class_ $class): array
    {
        return [];
    }

    public function generatePropertyAttributes(Property $property, string $className): array
    {
        return [];
    }

    public function generateLateClassAttributes(Class_ $class): array
    {
        return [];
    }

    public function generateUses(Class_ $class): array
    {
        return [];
    }
}
