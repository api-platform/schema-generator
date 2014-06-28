<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

/**
 * PHPDoc annotation generator
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class PhpDocAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
    {
        $type = $this->schemaOrg->types->$className;

        $annotations = [
            $type->label,
            ''
        ];

        if ($this->config['author']) {
            $annotations[] = sprintf('@author %s', $this->config['author']);
        }

        $annotations[] = sprintf('@link %s', $type->url);
        $annotations[] = '';

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName, $range)
    {
        $property = $this->schemaOrg->properties->$fieldName;

        return [
            $property->label,
            '',
            sprintf('@var %s $%s %s', self::toPhpType($range), $fieldName, $property->comment_plain),
            ''
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses($className)
    {
        return [];
    }

    /**
     * Converts a Schema.org range to a PHP type
     *
     * @param $range
     * @return string
     */
    public static function toPhpType($range)
    {
        switch ($range) {
            case 'Boolean':
                return 'boolean';
                break;
            case 'Date':
                // No break
            case 'DateTime':
                // No break
            case 'Time':
                return '\DateTime';
                break;
            case 'Number':
                // No break
            case 'Float':
                return 'float';
                break;
            case 'Integer':
                return 'integer';
                break;
            case 'Text':
                // No break
            case 'URL':
                return 'string';
                break;
        }

        return $range;
    }
}
