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

final class PhpTypeConverter implements PhpTypeConverterInterface
{
    public function getPhpType(Property $property, array $config = [], array $classes = []): ?string
    {
        if (!$property instanceof SchemaProperty) {
            throw new \LogicException(sprintf('Property "%s" has to be an instance of "%s".', $property->name(), SchemaProperty::class));
        }

        if ($property->reference && $property->isArray()) {
            return ($config['doctrine']['useCollection'] ?? false) ? 'Collection' : 'array';
        }

        if ($property->isArray()) {
            return 'array';
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
            return $property->type->getPhp();
        }

        $typeName = $property->rangeName;
        if ($type = (isset($classes[$typeName]) ? $classes[$typeName]->interfaceName() ?? $classes[$typeName]->name() : null)) {
            return $type;
        }

        return null;
    }
}
