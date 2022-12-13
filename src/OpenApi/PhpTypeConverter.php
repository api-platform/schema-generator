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

namespace ApiPlatform\SchemaGenerator\OpenApi;

use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;

final class PhpTypeConverter implements PhpTypeConverterInterface
{
    public function getPhpType(Property $property, array $config = [], array $classes = []): ?string
    {
        if ($property->reference && $property->isArray()) {
            return ($config['doctrine']['useCollection'] ?? false) ? 'Collection' : 'array';
        }

        if ($property->reference && !$property->isArray()) {
            return $property->reference->name();
        }

        if ($property->isArray()) {
            return 'array';
        }

        if (!$property->type) {
            return 'string';
        }

        return $property->type->getPhp();
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
}
