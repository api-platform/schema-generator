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
    public function generateClassAnnotations(\EasyRdf_Resource $class)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $instance, $name)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $field, $range)
    {
        switch ($range) {
            case 'URL':
                return ['@Assert\Url'];

            case 'Date':
                return ['@Assert\Date'];

            case 'DateTime':
                return ['@Assert\DateTime'];

            case 'Time':
                return ['@Assert\Time'];
        }

        if ('email' === $field->localName()) {
            return ['@Assert\Email'];
        }

        $phpType = PhpDocAnnotationGenerator::toPhpType($range);
        if (in_array($phpType, ['boolean', 'float', 'integer', 'string'])) {
            return [sprintf('@Assert\Type(type="%s")', $phpType)];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(\EasyRdf_Resource $class)
    {
        $subClassOf = $class->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['Symfony\Component\Validator\Constraints as Assert'];
    }
}
