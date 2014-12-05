<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\AnnotationGenerator;

/**
 * PHPDoc annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class PhpDocAnnotationGenerator extends AbstractAnnotationGenerator
{
    const INDENT = '   ';

    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations($className)
    {
        return $this->generateDoc($className);
    }

    /**
     * {@inheritdoc}
     */
    public function generateInterfaceAnnotations($className)
    {
        return $this->generateDoc($className, true);
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations($className, $constantName)
    {
        $resource = $this->classes[$className]['constants'][$constantName]['resource'];

        $annotations = $this->formatDoc($resource->get('rdfs:comment'), true);
        $annotations[0] = sprintf(
            '@type %s %s',
            'string',
            $constantName,
            $annotations[0]
        );

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations($className, $fieldName)
    {
        $field = $this->classes[$className]['fields'][$fieldName];

        $annotations = $this->formatDoc($field['resource']->get('rdfs:comment'), true);
        $annotations[0] = sprintf(
            '@%s %s $%s %s',
            $this->config['useType'] ? 'type' : 'var',
            $this->toPhpType($field),
            $fieldName,
            $annotations[0]
        );

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateGetterAnnotations($className, $fieldName)
    {
        return [
            sprintf('Gets %s.', $fieldName),
            '',
            sprintf('@return %s', $this->toPhpType($this->classes[$className]['fields'][$fieldName])),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateSetterAnnotations($className, $fieldName)
    {
        return [
            sprintf('Sets %s.', $fieldName),
            '',
            sprintf(
                '@param  %s $%s',
                $this->toPhpType($this->classes[$className]['fields'][$fieldName]),
                $fieldName
            ),
            '@return $this',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateAdderAnnotations($className, $fieldName)
    {
        return [
            sprintf('Adds %s.', $fieldName),
            '',
            sprintf(
                '@param  %s $%s',
                $this->toPhpType($this->classes[$className]['fields'][$fieldName], true),
                $fieldName
            ),
            '@return $this',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateRemoverAnnotations($className, $fieldName)
    {
        return [
            sprintf('Removes %s.', $fieldName),
            '',
            sprintf(
                '@param  %s $%s',
                $this->toPhpType($this->classes[$className]['fields'][$fieldName], true),
                $fieldName
            ),
            '@return $this',
        ];
    }

    /**
     * Generates class or interface PHPDoc
     *
     * @param  string $className
     * @param  bool   $interface
     * @return array
     */
    private function generateDoc($className, $interface = false)
    {
        $resource = $this->classes[$className]['resource'];
        $annotations = [];

        if (!$interface && isset($this->classes[$className]['interfaceName'])) {
            $annotations[] = '{@inheritdoc}';
            $annotations[] = '';
        } else {
            $annotations = $this->formatDoc($resource->get('rdfs:comment'));
            $annotations[] = '';
            $annotations[] = sprintf('@see %s %s', $resource->getUri(), 'Documentation on Schema.org');
        }

        if ($this->config['author']) {
            $annotations[] = sprintf('@author %s', $this->config['author']);
        }

        return $annotations;
    }

    /**
     * Converts HTML to Markdown and explode
     *
     * @param  string $doc
     * @param  bool   $indent
     * @return array
     */
    private function formatDoc($doc, $indent = false)
    {
        $doc = explode("\n", (new \HTML_To_Markdown($doc))->output());

        if ($indent) {
            $count = count($doc);
            for ($i = 1; $i < $count; $i++) {
                $doc[$i] = self::INDENT.$doc[$i];
            }
        }

        return $doc;
    }
}
