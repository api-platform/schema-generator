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

use League\HTMLToMarkdown\HtmlConverter;
use Psr\Log\LoggerInterface;

/**
 * PHPDoc annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class PhpDocAnnotationGenerator extends AbstractAnnotationGenerator
{
    const INDENT = '   ';

    /**
     * @var HtmlConverter
     */
    private $htmlToMarkdown;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        LoggerInterface $logger,
        array $graphs,
        array $cardinalities,
        array $config,
        array $classes
    ) {
        parent::__construct($logger, $graphs, $cardinalities, $config, $classes);

        $this->htmlToMarkdown = new HtmlConverter();
    }

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
            '@var string %s',
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
        $comment = $field['resource'] ? $field['resource']->get('rdfs:comment') : '';

        $annotations = $this->formatDoc($comment, true);
        $annotations[0] = sprintf(
            '@var %s %s',
            $this->toPhpType($field),
            $annotations[0]
        );
        $annotations[] = '';

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
            '',
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
            '',
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
            '',
            '@return $this',
        ];
    }

    /**
     * Generates class or interface PHPDoc.
     *
     * @param string $className
     * @param bool   $interface
     *
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
     * Converts HTML to Markdown and explode.
     *
     * @param string $doc
     * @param bool   $indent
     *
     * @return array
     */
    private function formatDoc($doc, $indent = false)
    {
        $doc = explode("\n", $this->htmlToMarkdown->convert($doc));

        if ($indent) {
            $count = count($doc);
            for ($i = 1; $i < $count; ++$i) {
                $doc[$i] = self::INDENT.$doc[$i];
            }
        }

        return $doc;
    }
}
