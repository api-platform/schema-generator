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
use EasyRdf\Resource as RdfResource;

final class IdPropertyGenerator
{
    public function __invoke(string $generationStrategy, bool $supportsWritableId): Property
    {
        switch ($generationStrategy) {
            case 'auto':
                $uri = 'https://schema.org/Integer';
                $typeHint = 'int';
                $writable = false;
                $nullable = true;
                break;
            case 'uuid':
                $uri = 'https://schema.org/Text';
                $typeHint = 'string';
                $writable = $supportsWritableId;
                $nullable = !$writable;
                break;
            case 'mongoid':
                $uri = 'https://schema.org/Text';
                $typeHint = 'string';
                $writable = false;
                $nullable = true;
                break;
            default:
                $uri = 'https://schema.org/Text';
                $typeHint = 'string';
                $writable = true;
                $nullable = false;
                break;
        }

        $property = new Property('id');
        $property->rangeName = 'Text';
        $property->range = new RdfResource($uri);
        $property->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $property->ormColumn = null;
        $property->isWritable = $writable;
        $property->isNullable = $nullable;
        $property->isUnique = false;
        $property->isCustom = true;
        $property->isId = true;
        $property->typeHint = $typeHint;

        return $property;
    }
}
