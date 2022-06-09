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

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\OpenApi\Model\Property as OpenApiProperty;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGenerator as CommonPropertyGenerator;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGeneratorInterface;
use cebe\openapi\spec\Schema;
use function Symfony\Component\String\u;

final class PropertyGenerator implements PropertyGeneratorInterface
{
    private PropertyGeneratorInterface $propertyGenerator;

    public function __construct(?PropertyGeneratorInterface $propertyGenerator = null)
    {
        $this->propertyGenerator = $propertyGenerator ?? new CommonPropertyGenerator();
    }

    /**
     * @param Configuration                           $config
     * @param array{schema: Schema, property: Schema} $context
     */
    public function __invoke(string $name, array $config, Class_ $class, array $context, bool $isCustom = false, ?Property $property = null): ?Property
    {
        $schema = $context['schema'];
        $schemaProperty = $context['property'];

        $openApiProperty = new OpenApiProperty($name);
        $openApiProperty->isArray = 'array' === $schemaProperty->type;

        $openApiProperty = ($this->propertyGenerator)($name, $config, $class, $context, $isCustom, $openApiProperty);

        if (!$openApiProperty instanceof OpenApiProperty) {
            throw new \LogicException(sprintf('Property has to be an instance of "%s".', OpenApiProperty::class));
        }

        $requiredFields = $schema->required ?? [];

        $openApiProperty->type = $this->getType($schemaProperty->type, $schemaProperty->format);
        $openApiProperty->arrayType = $openApiProperty->isArray && $schemaProperty->items instanceof Schema
            ? $this->getType($schemaProperty->items->type, $schemaProperty->items->format)
            : null;
        if ($schemaProperty->description) {
            $openApiProperty->setDescription($schemaProperty->description);
        }
        if ($schemaProperty->externalDocs) {
            $openApiProperty->setRdfType($schemaProperty->externalDocs->url);
        }
        $openApiProperty->isNullable = $schemaProperty->nullable ?? false;
        $openApiProperty->isRequired = \in_array($name, $requiredFields, true);
        $openApiProperty->isReadable = !$schemaProperty->writeOnly;
        $openApiProperty->isWritable = !$schemaProperty->readOnly;
        $openApiProperty->isEnum = (bool) $schemaProperty->enum;

        return $openApiProperty;
    }

    private function getType(string $type, ?string $format): ?string
    {
        if ($format) {
            switch ($format) {
                case 'int32':
                case 'int64':
                    return 'integer';
                default:
                    return u(str_replace('-', '_', $format))->camel()->toString();
            }
        }

        if (\in_array($type, ['array', 'object'], true)) {
            return null;
        }

        return $type;
    }
}
