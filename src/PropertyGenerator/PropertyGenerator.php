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

namespace ApiPlatform\SchemaGenerator\PropertyGenerator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;

final class PropertyGenerator implements PropertyGeneratorInterface
{
    /**
     * @param Configuration $config
     * @param array{}       $context
     */
    public function __invoke(string $name, array $config, Class_ $class, array $context, bool $isCustom = false, Property $property = null): ?Property
    {
        if (!$property) {
            throw new \LogicException('A property must be given.');
        }

        $property->isCustom = $isCustom;

        if ($property->isArray()) {
            $class->hasConstructor = true;
        }

        return $property;
    }
}
