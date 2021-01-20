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

interface PhpTypeConverterInterface
{
    public const BASE_MAPPING = [
        // bool
        'http://www.w3.org/2001/XMLSchema#boolean' => 'bool',
        'http://schema.org/Boolean' => 'bool',
        // float
        'http://www.w3.org/2001/XMLSchema#float' => 'float',
        'http://www.w3.org/2001/XMLSchema#double' => 'float',
        'http://schema.org/Float' => 'float',
        // int
        'http://schema.org/Integer' => 'int',
        'http://www.w3.org/2001/XMLSchema#integer' => 'int',
        'http://www.w3.org/2001/XMLSchema#nonPositiveInteger' => 'int',
        'http://www.w3.org/2001/XMLSchema#nonNegativeInteger' => 'int',
        'http://www.w3.org/2001/XMLSchema#long' => 'int',
        'http://www.w3.org/2001/XMLSchema#int' => 'int',
        'http://www.w3.org/2001/XMLSchema#short' => 'int',
        'http://www.w3.org/2001/XMLSchema#byte' => 'int',
        'http://www.w3.org/2001/XMLSchema#unsignedLong' => 'int',
        'http://www.w3.org/2001/XMLSchema#positiveInteger' => 'int',
        'http://www.w3.org/2001/XMLSchema#unsignedInt' => 'int',
        'http://www.w3.org/2001/XMLSchema#unsignedShort' => 'int',
        'http://www.w3.org/2001/XMLSchema#unsignedByte' => 'int',
        // string
        'http://www.w3.org/2001/XMLSchema#string' => 'string',
        'http://www.w3.org/2001/XMLSchema#hexBinary' => 'string',
        'http://www.w3.org/2001/XMLSchema#base64Binary' => 'string',
        'http://www.w3.org/2001/XMLSchema#anyURI' => 'string',
        'http://www.w3.org/2001/XMLSchema#QName' => 'string',
        'http://www.w3.org/2001/XMLSchema#NOTATION' => 'string',
        'http://www.w3.org/2001/XMLSchema#decimal' => 'string',
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
        'http://schema.org/Text' => 'string',
        'http://schema.org/URL' => 'string',
        'http://schema.org/Number' => 'string',
        // DateTimeInterface
        'http://www.w3.org/2001/XMLSchema#dateTime' => '\\'.\DateTimeInterface::class,
        'http://www.w3.org/2001/XMLSchema#time' => '\\'.\DateTimeInterface::class,
        'http://www.w3.org/2001/XMLSchema#date' => '\\'.\DateTimeInterface::class,
        'http://www.w3.org/2001/XMLSchema#gYearMonth' => '\\'.\DateTimeInterface::class,
        'http://www.w3.org/2001/XMLSchema#gYear' => '\\'.\DateTimeInterface::class,
        'http://www.w3.org/2001/XMLSchema#gMonthDay' => '\\'.\DateTimeInterface::class,
        'http://www.w3.org/2001/XMLSchema#gDay' => '\\'.\DateTimeInterface::class,
        'http://www.w3.org/2001/XMLSchema#gMonth' => '\\'.\DateTimeInterface::class,
        'http://schema.org/Date' => '\\'.\DateTimeInterface::class,
        'http://schema.org/DateTime' => '\\'.\DateTimeInterface::class,
        'http://schema.org/Time' => '\\'.\DateTimeInterface::class,
        // DateInterval
        'http://www.w3.org/2001/XMLSchema#duration' => '\\'.\DateInterval::class,
        // mixed
        'http://schema.org/DataType' => null,
    ];

    /**
     * @internal
     */
    public const RESERVED_KEYWORDS = [
        '__halt_compiler', 'abstract', 'and', 'array', 'as', 'break', 'callable', 'case', 'catch', 'class', 'clone', 'const', 'continue', 'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'final', 'for', 'foreach', 'function', 'global', 'goto', 'if', 'implements', 'include', 'include_once', 'instanceof', 'insteadof', 'interface', 'isset', 'list', 'namespace', 'new', 'object', 'or', 'print', 'private', 'protected', 'public', 'require', 'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'try', 'unset', 'use', 'var', 'while', 'xor', // PHP
        'collection', // Doctrine
    ];

    /**
     * Is this type a datatype?
     */
    public function isDatatype(Resource $range): bool;

    /**
     * Gets the PHP type of this field.
     */
    public function getPhpType(array $field, array $config = [], array $classes = []): ?string;

    /**
     * Escapes an identifier.
     */
    public function escapeIdentifier(string $identifier): string;
}
