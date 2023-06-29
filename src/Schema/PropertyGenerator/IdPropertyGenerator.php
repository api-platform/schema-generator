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

namespace ApiPlatform\SchemaGenerator\Schema\PropertyGenerator;

use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Type\PrimitiveType;
use ApiPlatform\SchemaGenerator\PropertyGenerator\IdPropertyGenerator as CommonIdPropertyGenerator;
use ApiPlatform\SchemaGenerator\PropertyGenerator\IdPropertyGeneratorInterface;
use ApiPlatform\SchemaGenerator\Schema\Model\Property as SchemaProperty;
use ApiPlatform\SchemaGenerator\Schema\Model\Type\PrimitiveType as SchemaPrimitiveType;
use EasyRdf\Resource as RdfResource;

final class IdPropertyGenerator implements IdPropertyGeneratorInterface
{
    private IdPropertyGeneratorInterface $idPropertyGenerator;

    public function __construct(IdPropertyGeneratorInterface $idPropertyGenerator = null)
    {
        $this->idPropertyGenerator = $idPropertyGenerator ?? new CommonIdPropertyGenerator();
    }

    public function __invoke(string $generationStrategy, bool $supportsWritableId, Property $property = null): Property
    {
        $idProperty = ($this->idPropertyGenerator)($generationStrategy, $supportsWritableId, new SchemaProperty('id'));

        if (!$idProperty instanceof SchemaProperty) {
            throw new \LogicException(sprintf('ID property has to be an instance of "%s".', SchemaProperty::class));
        }

        $idProperty->type = $idProperty->type instanceof PrimitiveType ? new SchemaPrimitiveType($idProperty->type->name) : null;

        $rangeName = 'Text';
        $uri = 'https://schema.org/Text';
        if ('auto' === $generationStrategy) {
            $rangeName = 'Integer';
            $uri = 'https://schema.org/Integer';
        }
        $idProperty->rangeName = $rangeName;
        $idProperty->range = new RdfResource($uri);

        return $idProperty;
    }
}
