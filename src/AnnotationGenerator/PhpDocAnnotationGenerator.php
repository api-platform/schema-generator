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

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Constant;
use ApiPlatform\SchemaGenerator\Model\Property;
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
    public function generateClassAnnotations(Class_ $class): array
    {
        return $this->generateDoc($class);
    }

    /**
     * {@inheritdoc}
     */
    public function generateInterfaceAnnotations(Class_ $class): array
    {
        return $this->generateDoc($class, true);
    }

    /**
     * {@inheritdoc}
     */
    public function generateConstantAnnotations(Constant $constant): array
    {
        $annotations = $this->formatDoc($constant->comment(), true);
        $annotations[0] = sprintf('@var string %s', $this->escapePhpDoc($annotations[0]));

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePropertyAnnotations(Property $property, string $className): array
    {
        $comment = $property->resource ? $property->resource->get('rdfs:comment') : '';

        $description = $this->formatDoc((string) $comment, true);

        $annotations = [];
        if ($this->isDocUseful($property)) {
            $annotations[] = sprintf('@var %s %s', $this->toPhpDocType($property), $this->escapePhpDoc($description[0]));
        } else {
            $annotations = $description;
            $annotations[] = '';
        }

        if (null !== $property->resource) {
            $annotations[] = sprintf('@see %s', $property->resourceUri());
        }

        $annotations[] = '';

        return $annotations;
    }

    /**
     * {@inheritdoc}
     */
    public function generateGetterAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property)) {
            return [];
        }

        return [sprintf('@return %s', $this->toPhpDocType($property))];
    }

    /**
     * {@inheritdoc}
     */
    public function generateSetterAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($property), $property->name())];
    }

    /**
     * {@inheritdoc}
     */
    public function generateAdderAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property, true)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($property, true), $this->inflector->singularize($property->name()))];
    }

    /**
     * {@inheritdoc}
     */
    public function generateRemoverAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property, true)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($property, true), $this->inflector->singularize($property->name()))];
    }

    private function isDocUseful(Property $property, bool $adderOrRemover = false): bool
    {
        $typeHint = $adderOrRemover ? $property->adderRemoverTypeHint ?? false : $property->typeHint ?? false;

        return false === $typeHint || 'array' === $typeHint;
    }

    /**
     * Generates class or interface PHPDoc.
     *
     * @return string[]
     */
    private function generateDoc(Class_ $class, bool $interface = false): array
    {
        $annotations = [];

        if (!$interface && null !== $class->interfaceName()) {
            $annotations[] = '{@inheritdoc}';
            $annotations[] = '';
        } else {
            $annotations = $this->formatDoc((string) $class->resourceComment());
            $annotations[] = '';
            $annotations[] = sprintf('@see %s', $class->resource());
        }

        if ($this->config['author']) {
            $annotations[] = sprintf('@author %s', $this->config['author']);
        }

        return $annotations;
    }

    /**
     * Converts HTML to Markdown and explode.
     *
     * @return string[]
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
    protected function toPhpDocType(Property $property, bool $adderOrRemover = false): ?string
    {
        $suffix = $property->isNullable ? '|null' : '';
        if ($property->isEnum) {
            if ($property->isArray) {
                return 'string[]'.$suffix;
            }

            return 'string'.$suffix;
        }

        $enforcedNonArrayProperty = clone $property;
        $enforcedNonArrayProperty->isArray = false;

        if (null !== $phpDocType = $this->phpTypeConverter->getPhpType($enforcedNonArrayProperty)) {
            return ($property->isArray ? sprintf('%s[]', $phpDocType) : $phpDocType).$suffix;
        }

        if (null === $property->range) {
            return null;
        }

        $phpDocType = isset($this->classes[$property->rangeName]) && $this->classes[$property->rangeName]->interfaceName() ?
            $this->classes[$property->rangeName]->interfaceName() : $property->rangeName;
        if (!$property->isArray || $adderOrRemover) {
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
