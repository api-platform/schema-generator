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

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Constraint annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class ConstraintAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generatePropertyAnnotations(Property $property, string $className): array
    {
        if ($property->isId) {
            if ('uuid' === $this->config['id']['generationStrategy']) {
                return ['@Assert\Uuid'];
            }

            return [];
        }

        $asserts = [];
        if (!$property->isArray && $property->range) {
            switch ($property->range->getUri()) {
                case 'http://schema.org/URL':
                    $asserts[] = '@Assert\Url';
                    break;
                case 'http://schema.org/Date':
                case 'http://schema.org/DateTime':
                case 'http://schema.org/Time':
                    $asserts[] = '@Assert\Type("\DateTimeInterface")';
                    break;
            }

            if ($property->resource !== null && 'http://schema.org/email' === $property->resourceUri()) {
                $asserts[] = '@Assert\Email';
            }

            if (!$asserts && $this->config['validator']['assertType']) {
                $phpType = $this->phpTypeConverter->getPhpType($property, $this->config, []);
                if (\in_array($phpType, ['bool', 'float', 'int', 'string'], true)) {
                    $asserts[] = sprintf('@Assert\Type(type="%s")', $phpType);
                }
            }
        }

        if (!$property->isNullable) {
            $asserts[] = '@Assert\NotNull';
        }

        if ($property->isEnum && $property->range) {
            $assert = sprintf('@Assert\Choice(callback={"%s", "toArray"}', $property->rangeName);

            if ($property->isArray) {
                $assert .= ', multiple=true';
            }

            $assert .= ')';

            $asserts[] = $assert;
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
        $uses[] = 'Symfony\Component\Validator\Constraints as Assert';
        $uses[] = UniqueEntity::class;

        foreach ($class->properties() as $property) {
            if ($property->isEnum && $property->range) {
                $rangeName = $property->rangeName;
                $enumClass = $this->classes[$rangeName];
                $enumNamespace = $enumClass->namespace() ?? $this->config['namespaces']['enum'];
                $use = sprintf('%s\%s', $enumNamespace, $rangeName);

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
    public function generateClassAnnotations(Class_ $class): array
    {
        if ($class->isEnum()) {
            return [];
        }

        $annotation = [];

        $uniqueProperties = $class->uniquePropertyNames();
        if (!$uniqueProperties) {
            return [];
        }

        if (1 === \count($uniqueProperties)) {
            $annotation[] = sprintf('@UniqueEntity("%s")', $uniqueProperties[0]);
        } else {
            $annotation[] = sprintf('@UniqueEntity(fields={"%s"})', implode('","', $uniqueProperties));
        }

        return $annotation;
    }
}
