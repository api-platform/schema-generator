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
        return isset(PhpTypeConverterInterface::BASE_MAPPING[$range->getUri()]);
    }

    public function getPhpType(array $field, array $config = [], array $classes = []): ?string
    {
        if ($field['isArray'] ?? false) {
            return $config['doctrine']['useCollection'] ?? false ? 'Collection' : 'array';
        }

        return $this->getNonArrayType($field, $classes);
    }

    private function getNonArrayType(array $field, array $classes): ?string
    {
        if ($field['isEnum']) {
            return 'string';
        }

        if (null === $field['range']) {
            return null;
        }

        $rangeUri = $field['range']->getUri();
        if (isset(PhpTypeConverterInterface::BASE_MAPPING[$rangeUri])) {
            return PhpTypeConverterInterface::BASE_MAPPING[$rangeUri];
        }

        $rangeName = $field['range']->localName();

        return $classes[$rangeName]['interfaceName'] ?? $classes[$rangeName]['name'] ?? null;
    }
}
