<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use Doctrine\Inflector\Inflector;
use League\HTMLToMarkdown\HtmlConverter;
use Psr\Log\LoggerInterface;

/**
 * PHPDoc annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class PhpDocAnnotationGenerator extends AbstractAnnotationGenerator
{
    private const INDENT = '   ';

    private HtmlConverter $htmlToMarkdown;

    /**
     * {@inheritdoc}
     */
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, LoggerInterface $logger, Inflector $inflector, array $graphs, array $cardinalities, array $config, array $classes)
    {
        parent::__construct($phpTypeConverter, $logger, $inflector, $graphs, $cardinalities, $config, $classes);

        $this->htmlToMarkdown = new HtmlConverter();
    }

    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(string $className): array
    {
        return $this->generateDoc($className);
    }

    /**
     * {@inheritdoc}
     */
    public function generateInterfaceAnnotations(string $className): array
    {
        return $this->generateDoc($className, true);
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations(string $className, string $constantName): array
    {
        $resource = $this->classes[$className]['constants'][$constantName]['resource'];

        $annotations = $this->formatDoc((string) $resource->get('rdfs:comment'), true);
        $annotations[0] = sprintf('@var string %s', $this->escapePhpDoc($annotations[0]));

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(string $className, string $fieldName): array
    {
        $field = $this->classes[$className]['fields'][$fieldName];
        $comment = $field['resource'] ? $field['resource']->get('rdfs:comment') : '';

        $description = $this->formatDoc((string) $comment, true);

        $annotations = [];
        $tags = false;
        if ($this->isDocUseful($className, $fieldName)) {
            $annotations[] = sprintf('@var %s %s', $this->toPhpDocType($field), $this->escapePhpDoc($description[0]));
        } else {
            $annotations = $description;
            $annotations[] = '';
        }

        if (isset($this->classes[$className]['fields'][$fieldName]['resource'])) {
            $annotations[] = sprintf('@see %s', $this->classes[$className]['fields'][$fieldName]['resource']->getUri());
        }

        $annotations[] = '';

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateGetterAnnotations(string $className, string $fieldName): array
    {
        if (!$this->isDocUseful($className, $fieldName)) {
            return [];
        }

        return [sprintf('@return %s', $this->toPhpDocType($this->classes[$className]['fields'][$fieldName]))];
    }

    /**
     * {@inheritdoc}
     */
    public function generateSetterAnnotations(string $className, string $fieldName): array
    {
        if (!$this->isDocUseful($className, $fieldName)) {
            return [];
        }

        $field = $this->classes[$className]['fields'][$fieldName];

        return [sprintf('@param %s $%s', $this->toPhpDocType($this->classes[$className]['fields'][$fieldName]), $field['name'])];
    }

    /**
     * {@inheritdoc}
     */
    public function generateAdderAnnotations(string $className, string $fieldName): array
    {
        if (!$this->isDocUseful($className, $fieldName, true)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($this->classes[$className]['fields'][$fieldName], true), $this->inflector->singularize($fieldName))];
    }

    /**
     * {@inheritdoc}
     */
    public function generateRemoverAnnotations(string $className, string $fieldName): array
    {
        if (!$this->isDocUseful($className, $fieldName, true)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($this->classes[$className]['fields'][$fieldName], true), $this->inflector->singularize($fieldName))];
    }

    private function isDocUseful(string $className, string $fieldName, $adderOrRemover = false): bool
    {
        $typeHint = $this->classes[$className]['fields'][$fieldName][$adderOrRemover ? 'adderRemoverTypeHint' : 'typeHint'] ?? false;

        return false === $typeHint || 'array' === $typeHint;
    }

    /**
     * Generates class or interface PHPDoc.
     */
    private function generateDoc(string $className, bool $interface = false): array
    {
        $resource = $this->classes[$className]['resource'];
        $annotations = [];

        if (!$interface && isset($this->classes[$className]['interfaceName'])) {
            $annotations[] = '{@inheritdoc}';
            $annotations[] = '';
        } else {
            $annotations = $this->formatDoc((string) $resource->get('rdfs:comment'));
            $annotations[] = '';
            $annotations[] = sprintf('@see %s', $resource->getUri());
        }

        if ($this->config['author']) {
            $annotations[] = sprintf('@author %s', $this->config['author']);
        }

        return $annotations;
    }

    /**
     * Converts HTML to Markdown and explode.
     */
    private function formatDoc(string $doc, bool $indent = false): array
    {
        $doc = explode("\n", $this->escapePhpDoc($this->htmlToMarkdown->convert($doc)));

        if ($indent) {
            $count = \count($doc);
            for ($i = 1; $i < $count; ++$i) {
                $doc[$i] = self::INDENT.$doc[$i];
            }
        }

        return $doc;
    }

    /**
     * Converts a RDF range to a PHPDoc type.
     */
    protected function toPhpDocType(array $field, bool $adderOrRemover = false): ?string
    {
        $suffix = $field['isNullable'] ? '|null' : '';
        if ($field['isEnum']) {
            if ($field['isArray']) {
                return 'string[]'.$suffix;
            }

            return 'string'.$suffix;
        }

        if (null !== $phpDocType = $this->phpTypeConverter->getPhpType(['isArray' => false] + $field)) {
            return ($field['isArray'] ? sprintf('%s[]', $phpDocType) : $phpDocType).$suffix;
        }

        if (!isset($field['range'])) {
            return null;
        }

        $rangeName = $field['rangeName'];
        $phpDocType = $this->classes[$rangeName]['interfaceName'] ?? $rangeName;
        if (!$field['isArray'] || $adderOrRemover) {
            return $phpDocType.$suffix;
        }

        if ($this->config['doctrine']['useCollection']) {
            return sprintf('Collection<%s>%s', $phpDocType, $suffix);
        }

        return sprintf('%s[]%s', $phpDocType, $suffix);
    }

    private function escapePhpDoc(string $text): string
    {
        return str_replace('@', '\\@', $text);
    }
}
