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
    public function generateClassAnnotations(\EasyRdf_Resource $class)
    {
        $annotations = explode("\n", html_entity_decode($class->get('rdfs:comment'), ENT_HTML5));
        // Add a blank line
        $annotations[] = '';

        if ($this->config['author']) {
            $annotations[] = sprintf('@author %s', $this->config['author']);
        }

        $annotations[] = sprintf('@see %s %s', $class->getUri(), 'Documentation on Schema.org');
        $annotations[] = '';

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $instance, $name)
    {
        return [
            sprintf('@type %s %s %s', 'string', $name, html_entity_decode($instance->get('rdfs:comment'), ENT_HTML5)),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(\EasyRdf_Resource $class, \EasyRdf_Resource $field, $range)
    {
        return [
            sprintf('@type %s $%s %s', self::toPhpType($range), $field->localName(), html_entity_decode($field->get('rdfs:comment'), ENT_HTML5)),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(\EasyRdf_Resource $class)
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
