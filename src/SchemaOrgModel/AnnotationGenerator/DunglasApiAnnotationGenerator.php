<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

use SchemaOrgModel\TypesGenerator;

/**
 * Generates Iri annotations provided by DunglasApiBundle.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @link https://github.com/dunglas/DunglasApiBundle
 */
class DunglasApiAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
    {
        $resource = $this->classes[$className]['resource'];

        return [sprintf('@Iri("%s")', $resource->getUri())];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        $resource = $this->classes[$className]['resource'];
        $resourceUrl = parse_url($resource->getUri());

        return 'id' === $fieldName ? [] : [sprintf('@Iri("%s://%s/%s")', $resourceUrl['scheme'], $resourceUrl['host'], $fieldName)];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['Dunglas\ApiBundle\Annotation\Iri'];
    }
}
