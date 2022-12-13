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

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\ClassMutator\AnnotationsAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\AttributeAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassIdAppender;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassInterfaceMutator;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassPropertiesTypehintMutator;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\OpenApi\ClassMutator\EnumClassMutator as OpenApiEnumClassMutator;
use ApiPlatform\SchemaGenerator\OpenApi\Model\Class_ as OpenApiClass;
use ApiPlatform\SchemaGenerator\OpenApi\PropertyGenerator\IdPropertyGenerator;
use ApiPlatform\SchemaGenerator\OpenApi\PropertyGenerator\PropertyGenerator;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGeneratorInterface;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Schema;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\String\Inflector\InflectorInterface;

use function Symfony\Component\String\u;

final class ClassGenerator
{
    use LoggerAwareTrait;
    use SchemaTraversalTrait;

    private InflectorInterface $inflector;
    private PhpTypeConverterInterface $phpTypeConverter;
    private PropertyGeneratorInterface $propertyGenerator;

    public function __construct(InflectorInterface $inflector, PhpTypeConverterInterface $phpTypeConverter)
    {
        $this->inflector = $inflector;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->propertyGenerator = new PropertyGenerator();
    }

    /**
     * @param Configuration $config
     *
     * @return Class_[]
     */
    public function generate(OpenApi $openApi, array $config): array
    {
        /** @var OpenApiClass[] $classes */
        $classes = [];

        foreach ($openApi->paths as $path => $pathItem) {
            // Matches only paths like /books/{id}.
            // Subresources and collection-only resources are not handled yet.
            if (!preg_match('@^[^{}]+/{[^{}]+}/?$@', $path)) {
                continue;
            }

            $explodedPath = explode('/', rtrim($path, '/'));
            $pathResourceName = $explodedPath[\count($explodedPath) - 2];
            $collectionResourceName = $this->inflector->pluralize($this->inflector->singularize($pathResourceName)[0])[0];
            $name = $this->inflector->singularize(u($pathResourceName)->camel()->title()->toString())[0];

            $showOperation = $pathItem->get;
            $editOperation = $pathItem->put ?? $pathItem->patch;
            if (null === $showOperation && null === $editOperation) {
                $this->logger ? $this->logger->warning(sprintf('No get, put or patch operation found for path "%s"', $path)) : null;
                continue;
            }

            $showSchema = null;
            if ($showOperation && $showOperation->responses && null !== $responseSchema = ($showOperation->responses[200]->content['application/json']->schema ?? null)) {
                $this->logger ? $this->logger->info(sprintf('Using show schema from get operation response for "%s" resource.', $name)) : null;
                $showSchema = $responseSchema;
            }
            if (!$showSchema && $openApi->components && isset($openApi->components->schemas[$name])) {
                $this->logger ? $this->logger->info(sprintf('Using "%s" show schema from components.', $name)) : null;
                $showSchema = $openApi->components->schemas[$name];
            }
            $editSchema = null;
            if ($editOperation && $editOperation->requestBody instanceof RequestBody && null !== $requestBodySchema = ($editOperation->requestBody->content['application/json']->schema ?? null)) {
                $this->logger ? $this->logger->info(sprintf('Using edit schema from put operation request body for "%s" resource.', $name)) : null;
                $editSchema = $requestBodySchema;
            }
            if (null === $showSchema && null === $editSchema) {
                $this->logger ? $this->logger->warning(sprintf('No schema found for path "%s"', $path)) : null;
                continue;
            }

            $showClass = null;
            if ($showSchema instanceof Schema) {
                $showClass = $this->buildClassFromSchema($showSchema, $name, $config);
                $classes = array_merge($this->buildEnumClasses($showSchema, $showClass, $config), $classes);
            }
            $editClass = null;
            if ($editSchema instanceof Schema) {
                $editClass = $this->buildClassFromSchema($editSchema, $name, $config);
                $classes = array_merge($this->buildEnumClasses($editSchema, $editClass, $config), $classes);
            }
            $class = $showClass ?? $editClass;
            if (!$class) {
                continue;
            }
            if ($showClass && $editClass) {
                $class = $this->mergeClasses($showClass, $editClass);
            }

            $putOperation = $pathItem->put;
            $patchOperation = $pathItem->patch;
            $deleteOperation = $pathItem->delete;
            $pathCollection = $openApi->paths->getPath(sprintf('/%s', $collectionResourceName));
            $listOperation = $pathCollection->get ?? null;
            $createOperation = $pathCollection->post ?? null;
            $class->operations = array_merge(
                $showOperation ? ['Get' => null] : [],
                $putOperation ? ['Put' => null] : [],
                $patchOperation ? ['Patch' => null] : [],
                $deleteOperation ? ['Delete' => null] : [],
                $listOperation ? ['GetCollection' => null] : [],
                $createOperation ? ['Post' => null] : [],
            );

            $classes[$name] = $class;
        }

        // Second pass
        $useInterface = $config['useInterface'];
        $generateId = $config['id']['generate'];
        foreach ($classes as $class) {
            if ($useInterface) {
                (new ClassInterfaceMutator($config['namespaces']['interface']))($class, []);
            }

            if ($generateId) {
                (new ClassIdAppender(new IdPropertyGenerator(), $config))($class, []);
            }

            // Try to guess the references from the property names.
            foreach ($class->properties() as $property) {
                if ($reference = $classes[preg_replace('/Ids?$/', '', $this->inflector->singularize(u($property->name())->title()->toString())[0])] ?? null) {
                    $property->reference = $reference;
                    $property->cardinality = $property->isNullable ? CardinalitiesExtractor::CARDINALITY_0_1 : CardinalitiesExtractor::CARDINALITY_1_1;
                    if ($property->isArray()) {
                        $property->cardinality = $property->isNullable ? CardinalitiesExtractor::CARDINALITY_0_N : CardinalitiesExtractor::CARDINALITY_1_N;
                    }
                }
            }
        }

        // Third pass
        foreach ($classes as $class) {
            (new ClassPropertiesTypehintMutator($this->phpTypeConverter, $config, $classes))($class, []);

            // Try to guess the mapped by from the references
            foreach ($class->properties() as $property) {
                if ($property->reference && $property->isArray()) {
                    $mappedByName = strtolower($class->name());
                    foreach ($property->reference->properties() as $referenceProperty) {
                        if ($mappedByName === $referenceProperty->name()) {
                            $property->mappedBy = $mappedByName;
                        }
                    }
                }
            }
        }

        // Initialize annotation generators
        $annotationGenerators = [];
        foreach ($config['annotationGenerators'] as $annotationGenerator) {
            $generator = new $annotationGenerator($this->phpTypeConverter, $this->inflector, $config, $classes);
            if (method_exists($generator, 'setLogger')) {
                $generator->setLogger($this->logger);
            }

            $annotationGenerators[] = $generator;
        }

        // Initialize attribute generators
        $attributeGenerators = [];
        foreach ($config['attributeGenerators'] as $attributeGenerator) {
            $generator = new $attributeGenerator($this->phpTypeConverter, $this->inflector, $config, $classes);
            if (method_exists($generator, 'setLogger')) {
                $generator->setLogger($this->logger);
            }

            $attributeGenerators[] = $generator;
        }

        $attributeAppender = new AttributeAppender($classes, $attributeGenerators);
        foreach ($classes as $class) {
            (new AnnotationsAppender($classes, $annotationGenerators, []))($class, []);
            $attributeAppender($class, []);
        }
        foreach ($classes as $class) {
            $attributeAppender->appendLate($class);
        }

        return $classes;
    }

    /**
     * @param Configuration $config
     */
    private function buildClassFromSchema(Schema $schema, string $name, array $config): OpenApiClass
    {
        $class = new OpenApiClass($name);

        $class->namespace = $config['namespaces']['entity'];

        if ($schema->description) {
            $class->setDescription($schema->description);
        }
        if ($schema->externalDocs) {
            $class->setRdfType($schema->externalDocs->url);
        }

        $schemaProperties = [];
        foreach ($this->getSchemaItem($schema) as $schemaItem) {
            $schemaProperties = array_merge($schemaProperties, $schemaItem->properties);
        }

        foreach ($schemaProperties as $propertyName => $schemaProperty) {
            \assert($schemaProperty instanceof Schema);
            $property = ($this->propertyGenerator)($propertyName, $config, $class, ['schema' => $schema, 'property' => $schemaProperty]);
            if ($property) {
                $class->addProperty($property);
            }
        }

        if ($config['doctrine']['useCollection']) {
            $class->addUse(new Use_(ArrayCollection::class));
            $class->addUse(new Use_(Collection::class));
        }

        return $class;
    }

    /**
     * @param Configuration $config
     *
     * @return OpenApiClass[]
     */
    private function buildEnumClasses(Schema $schema, OpenApiClass $class, array $config): array
    {
        $enumClasses = [];

        foreach ($schema->properties as $propertyName => $schemaProperty) {
            \assert($schemaProperty instanceof Schema);
            if ($schemaProperty->enum) {
                $name = $class->name().u($propertyName)->camel()->title()->toString();

                $enumClass = new OpenApiClass($name);
                (new OpenApiEnumClassMutator(
                    $this->phpTypeConverter,
                    $config['namespaces']['enum'],
                    $schemaProperty->enum
                ))($enumClass, []);
                $enumClasses[$name] = $enumClass;

                if ($classProperty = $class->getPropertyByName($propertyName)) {
                    $classProperty->reference = $enumClass;
                }
            }
        }

        return $enumClasses;
    }

    private function mergeClasses(OpenApiClass $classA, OpenApiClass $classB): OpenApiClass
    {
        foreach ($classB->properties() as $propertyB) {
            if (!$classA->getPropertyByName($propertyB->name())) {
                $classA->addProperty($propertyB);
            }
        }

        return $classA;
    }
}
