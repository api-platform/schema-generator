<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use ApiPlatform\SchemaGenerator\TypesGenerator;

/**
 * Generates API Platform core annotations.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @link https://github.com/api-platform/core
 */
class ApiPlatformCoreAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
    {
        $resource = $this->classes[$className]['resource'];

        return [sprintf('@ApiResource(iri="%s")', $resource->getUri())];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        return $this->classes[$className]['fields'][$fieldName]['isCustom'] ? [] : [sprintf('@ApiProperty(iri="http://schema.org/%s")', $fieldName)];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['ApiPlatform\Core\Annotation\ApiResource', 'ApiPlatform\Core\Annotation\ApiProperty'];
    }
}
