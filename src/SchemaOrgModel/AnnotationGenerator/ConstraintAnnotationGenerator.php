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
 * Constraint annotation generator
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ConstraintAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateInterfaceAnnotations($className)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations($className, $constantName)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        $field = $this->classes[$className]['fields'][$fieldName];

        switch ($field['range']) {
            case 'URL':
                return ['@Assert\Url'];

            case 'Date':
                return ['@Assert\Date'];

            case 'DateTime':
                return ['@Assert\DateTime'];

            case 'Time':
                return ['@Assert\Time'];
        }

        if ('email' === $field['resource']->localName()) {
            return ['@Assert\Email'];
        }

        $phpType = $this->toPhpType($field['range']);
        if (in_array($phpType, ['boolean', 'float', 'integer', 'string'])) {
            return [sprintf('@Assert\Type(type="%s")', $phpType)];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        $resource = $this->classes[$className]['resource'];
        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['Symfony\Component\Validator\Constraints as Assert'];
    }
}
