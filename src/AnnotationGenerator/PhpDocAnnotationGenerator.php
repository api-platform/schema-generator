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
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\String\Inflector\InflectorInterface;

/**
 * PHPDoc annotation generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class PhpDocAnnotationGenerator extends AbstractAnnotationGenerator
{
    private const INDENT = '   ';

    private HtmlConverter $htmlToMarkdown;

    public function __construct(PhpTypeConverterInterface $phpTypeConverter, InflectorInterface $inflector, array $config, array $classes)
    {
        parent::__construct($phpTypeConverter, $inflector, $config, $classes);

        $this->htmlToMarkdown = new HtmlConverter();
    }

    public function generateClassAnnotations(Class_ $class): array
    {
        return $this->generateDoc($class);
    }

    public function generateInterfaceAnnotations(Class_ $class): array
    {
        return $this->generateDoc($class, true);
    }

    public function generateConstantAnnotations(Constant $constant): array
    {
        $annotations = $this->formatDoc($constant->comment(), true);
        $annotations[0] = sprintf('@var string %s', $this->escapePhpDoc($annotations[0]));

        return $annotations;
    }

    public function generatePropertyAnnotations(Property $property, string $className): array
    {
        $description = $this->formatDoc((string) $property->description(), true);

        $annotations = [];
        if ($this->isDocUseful($property) && $phpDocType = $this->toPhpDocType($property)) {
            $annotations[] = sprintf('@var %s %s', $phpDocType, $this->escapePhpDoc($description[0]));
        } else {
            $annotations = $description;
            $annotations[] = '';
        }

        if (null !== $property->rdfType()) {
            $annotations[] = sprintf('@see %s', $property->rdfType());
        }

        $annotations[] = '';

        return $annotations;
    }

    public function generateGetterAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property)) {
            return [];
        }

        return [sprintf('@return %s', $this->toPhpDocType($property))];
    }

    public function generateSetterAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($property), $property->name())];
    }

    public function generateAdderAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property, true)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($property, true), $this->inflector->singularize($property->name())[0])];
    }

    public function generateRemoverAnnotations(Property $property): array
    {
        if (!$this->isDocUseful($property, true)) {
            return [];
        }

        return [sprintf('@param %s $%s', $this->toPhpDocType($property, true), $this->inflector->singularize($property->name())[0])];
    }

    private function isDocUseful(Property $property, bool $adderOrRemover = false): bool
    {
        $typeHint = $adderOrRemover ? $property->adderRemoverTypeHint : $property->typeHint;

        return \in_array($typeHint, [false, 'array', 'Collection'], true);
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
            if ($class->description()) {
                $annotations = $this->formatDoc($class->description());
                $annotations[] = '';
            }
            if ($class->rdfType()) {
                $annotations[] = sprintf('@see %s', $class->rdfType());
            }
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

    protected function toPhpDocType(Property $property, bool $adderOrRemover = false): ?string
    {
        $suffix = $property->isNullable ? '|null' : '';
        if ($property->isEnum) {
            if ($property->isArray()) {
                return 'string[]'.$suffix;
            }

            return 'string'.$suffix;
        }

        if (!$property->reference && null !== $phpDocType = $this->phpTypeConverter->getPhpType($property)) {
            if ('array' === $phpDocType && $property->type) {
                $phpDocType = $property->type->getPhp();
            }

            return $phpDocType.$suffix;
        }

        if (!$property->reference) {
            return null;
        }

        $phpDocType = $property->reference->interfaceName() ?: $property->reference->name();
        if ($adderOrRemover || !$property->isArray()) {
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
