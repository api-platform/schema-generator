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

namespace ApiPlatform\SchemaGenerator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Schema\Model\Property as SchemaProperty;
use ApiPlatform\SchemaGenerator\Schema\TypeConverter;
use EasyRdf\Resource as RdfResource;

final class PhpTypeConverter implements PhpTypeConverterInterface
{
    private const RDF_LANG_STRING = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#langString';

    /**
     * Is this type a datatype?
     */
    public function isDatatype(RdfResource $range): bool
    {
        return isset(TypeConverter::RANGE_MAPPING[$this->getUri($range)]) || $this->isLangString($range);
    }

    public function getPhpType(Property $property, array $config = [], array $classes = []): ?string
    {
        if (!$property instanceof SchemaProperty) {
            throw new \LogicException(sprintf('Property "%s" has to be an instance of "%s".', $property->name(), SchemaProperty::class));
        }

        if ($property->isArray && $property->range) {
            return ($config['doctrine']['useCollection'] ?? false) && !$this->isDatatype($property->range) ? 'Collection' : 'array';
        }

        return $this->getNonArrayType($property, $classes);
    }

    public function escapeIdentifier(string $identifier): string
    {
        foreach (self::RESERVED_KEYWORDS as $keyword) {
            if (0 === strcasecmp($keyword, $identifier)) {
                return $identifier.'_';
            }
        }

        return $identifier;
    }

    /**
     * @param Class_[] $classes
     */
    private function getNonArrayType(SchemaProperty $property, array $classes): ?string
    {
        if ($property->isEnum) {
            return 'string';
        }

        if (null === $property->range) {
            return null;
        }

        if ($property->type) {
            switch ($property->type) {
                case 'integer':
                case 'negativeInteger':
                case 'nonNegativeInteger':
                case 'positiveInteger':
                case 'nonPositiveInteger':
                case 'byte':
                    return 'int';
                case 'boolean':
                    return 'bool';
                case 'float':
                case 'double':
                case 'decimal':
                    return 'float';
                case 'date':
                case 'dateTime':
                case 'time':
                    return '\\'.\DateTimeInterface::class;
                case 'duration':
                    return '\\'.\DateInterval::class;
                case 'mixed':
                    return null;
                default:
                    return 'string';
            }
        }

        $typeName = $property->rangeName;
        if ($type = (isset($classes[$typeName]) ? $classes[$typeName]->interfaceName() ?? $classes[$typeName]->name() : null)) {
            return $type;
        }

        if ($this->isLangString($property->range)) {
            return 'string';
        }

        return null;
    }

    /**
     * This is a hack to detect internationalized strings.
     *
     * @todo find something smarter to detect this kind of strings
     */
    private function isLangString(RdfResource $range): bool
    {
        return self::RDF_LANG_STRING === $this->getUri($range)
            || ($range->isBNode() &&
            null !== ($unionOf = $range->get('owl:unionOf')) &&
            null !== ($rdfFirst = $unionOf->get('rdf:first')) &&
            self::RDF_LANG_STRING === $rdfFirst->getUri());
    }

    private function getUri(RdfResource $range): string
    {
        if ($range->isBNode() && $onDatatype = $range->get('owl:onDatatype')) {
            return $onDatatype->getUri();
        }

        return $range->getUri();
    }
}
