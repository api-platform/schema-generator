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
use ApiPlatform\SchemaGenerator\Model\Type\ArrayType;
use ApiPlatform\SchemaGenerator\Model\Type\Type;
use ApiPlatform\SchemaGenerator\Model\Type\UnionType;
use ApiPlatform\SchemaGenerator\OpenApi\Model\Property as OpenApiProperty;
use ApiPlatform\SchemaGenerator\OpenApi\Model\Type\PrimitiveType;
use ApiPlatform\SchemaGenerator\OpenApi\SchemaTraversalTrait;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGenerator as CommonPropertyGenerator;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGeneratorInterface;
use cebe\openapi\spec\Schema;

use function Symfony\Component\String\u;

final class PropertyGenerator implements PropertyGeneratorInterface
{
    use SchemaTraversalTrait;

    private PropertyGeneratorInterface $propertyGenerator;

    public function __construct(PropertyGeneratorInterface $propertyGenerator = null)
    {
        $this->propertyGenerator = $propertyGenerator ?? new CommonPropertyGenerator();
    }

    /**
     * @param Configuration                           $config
     * @param array{schema: Schema, property: Schema} $context
     */
    public function __invoke(string $name, array $config, Class_ $class, array $context, bool $isCustom = false, Property $property = null): ?Property
    {
        $schema = $context['schema'];
        $schemaProperty = $context['property'];

        $openApiProperty = new OpenApiProperty($name);
        $openApiProperty->type = $this->getType($schemaProperty);

        $openApiProperty = ($this->propertyGenerator)($name, $config, $class, $context, $isCustom, $openApiProperty);

        if (!$openApiProperty instanceof OpenApiProperty) {
            throw new \LogicException(sprintf('Property has to be an instance of "%s".', OpenApiProperty::class));
        }

        $requiredFields = $schema->required ?? [];

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

    private function getType(Schema $schemaProperty, bool $inComposite = false): ?Type
    {
        if ($schemaProperty->oneOf) {
            $types = [];
            foreach ($schemaProperty->oneOf as $oneOfProperty) {
                \assert($oneOfProperty instanceof Schema);
                if ($oneOfType = $this->getType($oneOfProperty, true)) {
                    $types[] = $oneOfType;
                }
            }

            return new UnionType($types);
        }

        // Merge properties.
        if ($schemaProperty->allOf) {
            $type = 'string';
            $format = 'string';
            foreach ($this->getSchemaItem($schemaProperty) as $schemaPropertyItem) {
                $type = $schemaPropertyItem->type ?? $type;
                $format = $schemaPropertyItem->format ?? $format;
            }
            $schemaProperty = new Schema([
                'type' => $type,
                'format' => $format,
            ]);
        }

        // Not supported.
        if ($schemaProperty->anyOf || $schemaProperty->not) {
            return null;
        }

        if ('array' === $schemaProperty->type) {
            return new ArrayType($schemaProperty->items instanceof Schema ? $this->getType($schemaProperty->items) : null);
        }

        $type = $schemaProperty->type;
        $format = $schemaProperty->format;

        $primitiveType = new PrimitiveType($type);

        if ($format) {
            switch ($format) {
                case 'int32':
                case 'int64':
                    $primitiveType = new PrimitiveType('integer');

                    break;
                default:
                    $primitiveType = new PrimitiveType(u(str_replace('-', '_', $format))->camel()->toString());
            }

            return $primitiveType;
        }

        if (!$inComposite && \in_array($type, ['array', 'object'], true)) {
            return null;
        }

        return $primitiveType;
    }
}
