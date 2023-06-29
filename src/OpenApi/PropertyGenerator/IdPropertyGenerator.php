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

namespace ApiPlatform\SchemaGenerator\OpenApi\PropertyGenerator;

use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Type\PrimitiveType;
use ApiPlatform\SchemaGenerator\OpenApi\Model\Property as OpenApiProperty;
use ApiPlatform\SchemaGenerator\OpenApi\Model\Type\PrimitiveType as OpenApiPrimitiveType;
use ApiPlatform\SchemaGenerator\PropertyGenerator\IdPropertyGenerator as CommonIdPropertyGenerator;
use ApiPlatform\SchemaGenerator\PropertyGenerator\IdPropertyGeneratorInterface;

final class IdPropertyGenerator implements IdPropertyGeneratorInterface
{
    private IdPropertyGeneratorInterface $idPropertyGenerator;

    public function __construct(IdPropertyGeneratorInterface $idPropertyGenerator = null)
    {
        $this->idPropertyGenerator = $idPropertyGenerator ?? new CommonIdPropertyGenerator();
    }

    public function __invoke(string $generationStrategy, bool $supportsWritableId, Property $property = null): Property
    {
        $idProperty = ($this->idPropertyGenerator)($generationStrategy, $supportsWritableId, new OpenApiProperty('id'));

        $idProperty->type = $idProperty->type instanceof PrimitiveType ? new OpenApiPrimitiveType($idProperty->type->name) : null;

        return $idProperty;
    }
}
