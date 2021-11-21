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

use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;
use Nette\PhpGenerator\Literal;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Constraint attribute generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class ConstraintAttributeGenerator extends AbstractAttributeGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generatePropertyAttributes(Property $property, string $className): array
    {
        if ($property->isId) {
            if ('uuid' === $this->config['id']['generationStrategy']) {
                return [new Attribute('Assert\Uuid')];
            }

            return [];
        }

        $asserts = [];

        if (!$property->isArray && $property->range) {
            switch ($property->range->getUri()) {
                case 'https://schema.org/URL':
                    $asserts[] = new Attribute('Assert\Url');
                    break;
                case 'https://schema.org/Date':
                case 'https://schema.org/DateTime':
                case 'https://schema.org/Time':
                    $asserts[] = new Attribute('Assert\Type', [new Literal('\DateTimeInterface::class')]);
                    break;
            }

            if (null !== $property->resource && 'https://schema.org/email' === $property->resourceUri()) {
                $asserts[] = new Attribute('Assert\Email');
            }

            if (!$asserts && $this->config['validator']['assertType']) {
                $phpType = $this->phpTypeConverter->getPhpType($property, $this->config, []);
                if (\in_array($phpType, ['bool', 'float', 'int', 'string'], true)) {
                    $asserts[] = new Attribute('Assert\Type', [$phpType]);
                }
            }
        }

        if (!$property->isNullable) {
            $asserts[] = new Attribute('Assert\NotNull');
        }

        if ($property->isEnum && $property->range && $property->rangeName) {
            $args = ['callback' => [$property->rangeName, 'toArray']];

            if ($property->isArray) {
                $args['multiple'] = true;
            }

            $asserts[] = new Attribute('Assert\Choice', $args);
        }

        return $asserts;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(Class_ $class): array
    {
        if ($class->isEnum()) {
            return [];
        }

        $uses = [];
        $uses[] = new Use_('Symfony\Component\Validator\Constraints', 'Assert');
        $uses[] = new Use_(UniqueEntity::class);

        foreach ($class->properties() as $property) {
            if ($property->isEnum && $property->range) {
                $rangeName = $property->rangeName;
                $enumClass = $this->classes[$rangeName];
                $enumNamespace = $enumClass->namespace ?? $this->config['namespaces']['enum'];
                $use = new Use_(sprintf('%s\%s', $enumNamespace, $rangeName));

                if (!\in_array($use, $uses, true)) {
                    $uses[] = $use;
                }
            }
        }

        return $uses;
    }

    /**
     * {@inheritdoc}
     */
    public function generateClassAttributes(Class_ $class): array
    {
        if ($class->isEnum()) {
            return [];
        }

        $attributes = [];

        $uniqueProperties = $class->uniquePropertyNames();
        if (!$uniqueProperties) {
            return [];
        }

        if (1 === \count($uniqueProperties)) {
            $attributes[] = new Attribute('UniqueEntity', [$uniqueProperties[0]]);
        } else {
            $attributes[] = new Attribute('UniqueEntity', ['fields' => $uniqueProperties]);
        }

        return $attributes;
    }
}
