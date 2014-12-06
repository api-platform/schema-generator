<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

use SchemaOrgModel\CardinalitiesExtractor;

/**
 * Constraint annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ConstraintAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        $field = $this->classes[$className]['fields'][$fieldName];

        if ($field['isId']) {
            return [];
        }

        $asserts = [];
        if (!$field['isArray']) {
            switch ($field['range']) {
                case 'URL':
                    $asserts[] = '@Assert\Url';
                    break;

                case 'Date':
                    $asserts[] = '@Assert\Date';
                    break;

                case 'DateTime':
                    $asserts[] = '@Assert\DateTime';
                    break;

                case 'Time':
                    $asserts[] = '@Assert\Time';
                    break;
            }

            if (isset($field['resource']) && 'email' === $field['resource']->localName()) {
                $asserts[] = '@Assert\Email';
            }

            if (!$asserts) {
                $phpType = $this->toPhpType($field);
                if (in_array($phpType, ['boolean', 'float', 'integer', 'string'])) {
                    $asserts[] = sprintf('@Assert\Type(type="%s")', $phpType);
                }
            }
        }

        if (CardinalitiesExtractor::CARDINALITY_1_1 === $field['cardinality'] || CardinalitiesExtractor::CARDINALITY_1_N === $field['cardinality']) {
            $asserts[] = '@Assert\NotNull';
        }

        return $asserts;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        return $this->classes[$className]['isEnum'] ? [] : ['Symfony\Component\Validator\Constraints as Assert'];
    }
}
