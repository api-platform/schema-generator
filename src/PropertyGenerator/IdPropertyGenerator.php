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

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Type\PrimitiveType;

final class IdPropertyGenerator implements IdPropertyGeneratorInterface
{
    public function __invoke(string $generationStrategy, bool $supportsWritableId, Property $property = null): Property
    {
        if (!$property) {
            throw new \LogicException('A property must be given.');
        }

        switch ($generationStrategy) {
            case 'auto':
                $type = 'integer';
                $typeHint = 'int';
                $writable = false;
                $nullable = true;
                break;
            case 'uuid':
                $type = 'string';
                $typeHint = 'string';
                $writable = $supportsWritableId;
                $nullable = !$writable;
                break;
            case 'mongoid':
                $type = 'string';
                $typeHint = 'string';
                $writable = false;
                $nullable = true;
                break;
            default:
                $type = 'string';
                $typeHint = 'string';
                $writable = true;
                $nullable = false;
                break;
        }

        $property->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $property->isWritable = $writable;
        $property->isNullable = $nullable;
        $property->isUnique = false;
        $property->isCustom = true;
        $property->isId = true;
        $property->type = new PrimitiveType($type);
        $property->typeHint = $typeHint;

        return $property;
    }
}
