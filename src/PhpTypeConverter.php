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

use EasyRdf\Resource;

final class PhpTypeConverter implements PhpTypeConverterInterface
{
    /**
     * Is this type a datatype?
     */
    public function isDatatype(Resource $range): bool
    {
        return isset(PhpTypeConverterInterface::BASE_MAPPING[$this->getUri($range)]) || $this->isLangString($range);
    }

    public function getPhpType(array $field, array $config = [], array $classes = []): ?string
    {
        if ($field['isArray'] ?? false) {
            return ($config['doctrine']['useCollection'] ?? false) && !$this->isDatatype($field['range']) ? 'Collection' : 'array';
        }

        return $this->getNonArrayType($field, $classes);
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

    private function getNonArrayType(array $field, array $classes): ?string
    {
        if ($field['isEnum']) {
            return 'string';
        }

        if (null === $field['range']) {
            return null;
        }

        $rangeUri = $this->getUri($field['range']);
        if (isset(PhpTypeConverterInterface::BASE_MAPPING[$rangeUri])) {
            return PhpTypeConverterInterface::BASE_MAPPING[$rangeUri];
        }

        $typeName = $field['rangeName'];
        if ($type = $classes[$typeName]['interfaceName'] ?? $classes[$typeName]['name'] ?? null) {
            return $type;
        }

        if ($this->isLangString($field['range'])) {
            return 'string';
        }

        return null;
    }

    /**
     * This is a hack to detect internationalized strings in ActivityStreams.
     *
     * @todo find something smarter to detect this kind of strings
     */
    private function isLangString(Resource $range): bool
    {
        return $range->isBNode() &&
            null !== ($unionOf = $range->get('owl:unionOf')) &&
            null !== ($rdfFirst = $unionOf->get('rdf:first')) &&
            'http://www.w3.org/1999/02/22-rdf-syntax-ns#langString' === $rdfFirst->getUri();
    }

    private function getUri(Resource $range): string
    {
        if ($range->isBNode() && $onDatatype = $range->get('owl:onDatatype')) {
            return $onDatatype->getUri();
        }

        return $range->getUri();
    }
}
