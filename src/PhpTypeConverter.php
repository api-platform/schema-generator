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
use EasyRdf\Resource as RdfResource;

final class PhpTypeConverter implements PhpTypeConverterInterface
{
    /**
     * Is this type a datatype?
     */
    public function isDatatype(RdfResource $range): bool
    {
        return isset(PhpTypeConverterInterface::BASE_MAPPING[$this->getUri($range)]) || $this->isLangString($range);
    }

    public function getPhpType(Property $property, array $config = [], array $classes = []): ?string
    {
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
    private function getNonArrayType(Property $property, array $classes): ?string
    {
        if ($property->isEnum) {
            return 'string';
        }

        if (null === $property->range) {
            return null;
        }

        $rangeUri = $this->getUri($property->range);
        if (isset(PhpTypeConverterInterface::BASE_MAPPING[$rangeUri])) {
            return PhpTypeConverterInterface::BASE_MAPPING[$rangeUri];
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
     * This is a hack to detect internationalized strings in ActivityStreams.
     *
     * @todo find something smarter to detect this kind of strings
     */
    private function isLangString(RdfResource $range): bool
    {
        return $range->isBNode() &&
            null !== ($unionOf = $range->get('owl:unionOf')) &&
            null !== ($rdfFirst = $unionOf->get('rdf:first')) &&
            'http://www.w3.org/1999/02/22-rdf-syntax-ns#langString' === $rdfFirst->getUri();
    }

    private function getUri(RdfResource $range): string
    {
        if ($range->isBNode() && $onDatatype = $range->get('owl:onDatatype')) {
            return $onDatatype->getUri();
        }

        return $range->getUri();
    }
}
