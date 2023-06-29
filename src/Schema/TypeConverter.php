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

namespace ApiPlatform\SchemaGenerator\Schema;

use EasyRdf\Resource as RdfResource;

final class TypeConverter
{
    public const RANGE_DATA_TYPE_MAPPING = [
        'https://schema.org/URL' => 'url',

        'https://schema.org/Boolean' => 'boolean',
        'http://www.w3.org/2001/XMLSchema#boolean' => 'boolean',

        'https://schema.org/Float' => 'float',
        'http://www.w3.org/2001/XMLSchema#float' => 'float',

        'http://www.w3.org/2001/XMLSchema#double' => 'double',

        'https://schema.org/Integer' => 'integer',
        'http://www.w3.org/2001/XMLSchema#integer' => 'integer',
        'http://www.w3.org/2001/XMLSchema#int' => 'integer',
        'http://www.w3.org/2001/XMLSchema#long' => 'integer',
        'http://www.w3.org/2001/XMLSchema#short' => 'integer',

        'http://www.w3.org/2001/XMLSchema#negativeInteger' => 'negativeInteger',

        'http://www.w3.org/2001/XMLSchema#nonNegativeInteger' => 'nonNegativeInteger',
        'http://www.w3.org/2001/XMLSchema#unsignedInt' => 'nonNegativeInteger',
        'http://www.w3.org/2001/XMLSchema#unsignedShort' => 'nonNegativeInteger',
        'http://www.w3.org/2001/XMLSchema#unsignedLong' => 'nonNegativeInteger',

        'http://www.w3.org/2001/XMLSchema#positiveInteger' => 'positiveInteger',

        'http://www.w3.org/2001/XMLSchema#nonPositiveInteger' => 'nonPositiveInteger',

        'http://www.w3.org/2001/XMLSchema#decimal' => 'decimal',

        'https://schema.org/Date' => 'date',
        'http://www.w3.org/2001/XMLSchema#date' => 'date',
        'http://www.w3.org/2001/XMLSchema#gYearMonth' => 'date',
        'http://www.w3.org/2001/XMLSchema#gYear' => 'date',
        'http://www.w3.org/2001/XMLSchema#gMonthDay' => 'date',
        'http://www.w3.org/2001/XMLSchema#gDay' => 'date',
        'http://www.w3.org/2001/XMLSchema#gMonth' => 'date',

        'https://schema.org/DateTime' => 'dateTime',
        'http://www.w3.org/2001/XMLSchema#dateTime' => 'dateTime',

        'http://www.w3.org/2001/XMLSchema#duration' => 'duration',

        'https://schema.org/Time' => 'time',
        'http://www.w3.org/2001/XMLSchema#time' => 'time',

        'http://www.w3.org/2001/XMLSchema#byte' => 'byte',
        'http://www.w3.org/2001/XMLSchema#unsignedByte' => 'byte',

        'http://www.w3.org/2001/XMLSchema#hexBinary' => 'hexBinary',

        'http://www.w3.org/2001/XMLSchema#base64Binary' => 'base64Binary',

        'https://schema.org/Text' => 'string',
        'https://schema.org/Number' => 'string',
        'http://www.w3.org/2001/XMLSchema#string' => 'string',
        'http://www.w3.org/2001/XMLSchema#anyURI' => 'string',
        'http://www.w3.org/2001/XMLSchema#QName' => 'string',
        'http://www.w3.org/2001/XMLSchema#NOTATION' => 'string',
        'http://www.w3.org/2001/XMLSchema#normalizedString' => 'string',
        'http://www.w3.org/2001/XMLSchema#token' => 'string',
        'http://www.w3.org/2001/XMLSchema#language' => 'string',
        'http://www.w3.org/2001/XMLSchema#NMTOKEN' => 'string',
        'http://www.w3.org/2001/XMLSchema#NMTOKENS' => 'string',
        'http://www.w3.org/2001/XMLSchema#Name' => 'string',
        'http://www.w3.org/2001/XMLSchema#NCName' => 'string',
        'http://www.w3.org/2001/XMLSchema#ID' => 'string',
        'http://www.w3.org/2001/XMLSchema#IDREF' => 'string',
        'http://www.w3.org/2001/XMLSchema#IDREFS' => 'string',
        'http://www.w3.org/2001/XMLSchema#ENTITY' => 'string',
        'http://www.w3.org/2001/XMLSchema#ENTITIES' => 'string',

        'http://www.w3.org/1999/02/22-rdf-syntax-ns#langString' => 'string',

        'https://schema.org/DataType' => 'mixed',
    ];

    public function getType(?RdfResource $range): ?string
    {
        if (!$range) {
            return null;
        }

        return self::RANGE_DATA_TYPE_MAPPING[$this->getUri($range)] ?? null;
    }

    private function getUri(RdfResource $range): string
    {
        if ($range->isBNode() && $onDatatype = $range->get('owl:onDatatype')) {
            return $onDatatype->getUri();
        }

        if ($range->isBNode()
            && null !== ($unionOf = $range->get('owl:unionOf'))
            && null !== ($rdfFirst = $unionOf->get('rdf:first'))) {
            return $rdfFirst->getUri();
        }

        return $range->getUri();
    }
}
