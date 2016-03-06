<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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

        return [sprintf('@Resource(iri="%s")', $resource->getUri())];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        return $this->classes[$className]['fields'][$fieldName]['isCustom'] ? [] : [sprintf('@Property(iri="http://schema.org/%s")', $fieldName)];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['ApiPlatform\Core\Annotation\Resource', 'ApiPlatform\Core\Annotation\Property'];
    }
}
