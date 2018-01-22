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

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\SchemaGenerator\TypesGenerator;

/**
 * Generates API Platform core annotations.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @see https://github.com/api-platform/core
 */
final class ApiPlatformCoreAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(string $className): array
    {
        $resource = $this->classes[$className]['resource'];

        return [sprintf('@ApiResource(iri="%s")', $resource->getUri())];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(string $className, string $fieldName): array
    {
        return $this->classes[$className]['fields'][$fieldName]['isCustom'] ? [] : [sprintf('@ApiProperty(iri="http://schema.org/%s")', $fieldName)];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(string $className): array
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && TypesGenerator::SCHEMA_ORG_ENUMERATION === $subClassOf->getUri();

        return $typeIsEnum ? [] : [ApiResource::class, ApiProperty::class];
    }
}
