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

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Type\ArrayType;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGenerator as CommonPropertyGenerator;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGeneratorInterface;
use ApiPlatform\SchemaGenerator\Schema\Model\Property as SchemaProperty;
use ApiPlatform\SchemaGenerator\Schema\Model\Type\PrimitiveType;
use ApiPlatform\SchemaGenerator\Schema\TypeConverter;
use EasyRdf\Resource as RdfResource;
use Psr\Log\LoggerAwareTrait;

final class PropertyGenerator implements PropertyGeneratorInterface
{
    use LoggerAwareTrait;

    /** @var string[] */
    private static array $rangeProperties = [
        'schema:rangeIncludes',
        'rdfs:range',
    ];

    private GoodRelationsBridge $goodRelationsBridge;
    private PhpTypeConverterInterface $phpTypeConverter;
    private TypeConverter $typeConverter;
    private PropertyGeneratorInterface $propertyGenerator;

    public function __construct(GoodRelationsBridge $goodRelationsBridge, TypeConverter $typeConverter, PhpTypeConverterInterface $phpTypeConverter, PropertyGeneratorInterface $propertyGenerator = null)
    {
        $this->goodRelationsBridge = $goodRelationsBridge;
        $this->typeConverter = $typeConverter;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->propertyGenerator = $propertyGenerator ?? new CommonPropertyGenerator();
    }

    /**
     * @param Configuration $config
     * @param array{
     *     type: RdfResource,
     *     typeConfig: ?TypeConfiguration,
     *     cardinalities: array<string, string>,
     *     property: RdfResource
     * } $context
     */
    public function __invoke(string $name, array $config, Class_ $class, array $context, bool $isCustom = false, Property $property = null): ?Property
    {
        $type = $context['type'];
        $typeConfig = $context['typeConfig'];
        $cardinalities = $context['cardinalities'];
        $typeProperty = $context['property'];

        $typeUri = $type->getUri();
        $propertyUri = $typeProperty->getUri();

        $propertyConfig = $typeConfig['properties'][$name] ?? null;

        // Warn when property are not part of GoodRelations
        if ($config['checkIsGoodRelations'] && !$this->goodRelationsBridge->exists($name)) {
            $this->logger ? $this->logger->warning(sprintf('The property "%s" (type "%s") is not part of GoodRelations.', $propertyUri, $typeUri)) : null;
        }

        // Warn when properties are legacy
        if (preg_match('/legacy spelling/', (string) $typeProperty->get('rdfs:comment'))) {
            $this->logger ? $this->logger->warning(sprintf('The property "%s" (type "%s") is legacy.', $propertyUri, $typeUri)) : null;
        }

        $ranges = [];
        foreach (self::$rangeProperties as $rangePropertyType) {
            /** @var RdfResource $range */
            foreach ($typeProperty->all($rangePropertyType, 'resource') as $range) {
                $ranges[] = $this->getRanges($range, $propertyConfig, $config);
            }
        }
        $ranges = array_merge(...$ranges);

        if (!$ranges) {
            if (isset($propertyConfig['range'])) {
                $ranges[] = new RdfResource($propertyConfig['range'], $type->getGraph());
            } else {
                $this->logger ? $this->logger->error(sprintf('The property "%s" (type "%s") has an unknown type. Add its type to the config file.', $propertyUri, $typeUri)) : null;
            }
        }

        if (\count($ranges) > 1) {
            $this->logger ? $this->logger->info(sprintf('The property "%s" (type "%s") has several types. Using the first one ("%s"). Other possible options: "%s".', $propertyUri, $typeUri, $ranges[0]->getUri(), implode('", "', array_map(static fn (RdfResource $range) => $range->getUri(), $ranges)))) : null;
        }

        $rangeName = null;
        $range = null;
        if (isset($ranges[0])) {
            $range = $ranges[0];
            if (!isset($propertyConfig['range']) && $mappedUri = ($config['rangeMapping'][$ranges[0]->getUri()] ?? false)) {
                $range = new RdfResource($mappedUri);
            }

            if (\is_string($range->localName())) {
                $rangeName = $this->phpTypeConverter->escapeIdentifier($range->localName());
            }
        }

        if (!$ranges) {
            return null;
        }

        $type = $this->typeConverter->getType($range);

        $cardinality = $propertyConfig['cardinality'] ?? CardinalitiesExtractor::CARDINALITY_UNKNOWN;
        if (CardinalitiesExtractor::CARDINALITY_UNKNOWN === $cardinality) {
            $cardinality = $cardinalities[$propertyUri] ?? CardinalitiesExtractor::CARDINALITY_UNKNOWN;
        }
        if (!$type && CardinalitiesExtractor::CARDINALITY_UNKNOWN === $cardinality) {
            $cardinality = $config['relations']['defaultCardinality'];
        }

        $isArray = \in_array($cardinality, [
            CardinalitiesExtractor::CARDINALITY_0_N,
            CardinalitiesExtractor::CARDINALITY_1_N,
            CardinalitiesExtractor::CARDINALITY_N_N,
        ], true);

        $schemaProperty = new SchemaProperty($name);
        if ($isArray) {
            $schemaProperty->type = new ArrayType($type ? new PrimitiveType($type) : null);
        } elseif ($type) {
            $schemaProperty->type = new PrimitiveType($type);
        }

        $schemaProperty = ($this->propertyGenerator)($name, $config, $class, $context, $isCustom, $schemaProperty);

        if (!$schemaProperty instanceof SchemaProperty) {
            throw new \LogicException(sprintf('Property has to be an instance of "%s".', SchemaProperty::class));
        }

        $isNullable = (bool) ($propertyConfig['nullable'] ?? !\in_array($cardinality, [
            CardinalitiesExtractor::CARDINALITY_1_1,
            CardinalitiesExtractor::CARDINALITY_1_N,
        ], true));

        $schemaProperty->resource = $typeProperty;
        $schemaProperty->range = $range;
        $schemaProperty->rangeName = $rangeName;
        $schemaProperty->defaultValue = $propertyConfig['defaultValue'] ?? null;
        $schemaProperty->cardinality = $cardinality;
        $schemaProperty->isReadable = $propertyConfig['readable'] ?? true;
        $schemaProperty->isWritable = $propertyConfig['writable'] ?? true;
        $schemaProperty->isNullable = $isNullable;
        $schemaProperty->isRequired = $propertyConfig['required'] ?? false;
        $schemaProperty->isUnique = $propertyConfig['unique'] ?? false;
        $schemaProperty->isEmbedded = $propertyConfig['embedded'] ?? false;
        $schemaProperty->mappedBy = $propertyConfig['mappedBy'] ?? null;
        $schemaProperty->inversedBy = $propertyConfig['inversedBy'] ?? null;
        $schemaProperty->groups = $propertyConfig['groups'] ?? [];

        return $schemaProperty;
    }

    /**
     * @param ?PropertyConfiguration $propertyConfig
     * @param Configuration          $config
     *
     * @return RdfResource[]
     */
    private function getRanges(RdfResource $range, ?array $propertyConfig, array $config): array
    {
        $localName = null;
        if (\is_string($range->localName())) {
            $localName = $range->localName();
        }
        $dataType = (bool) $this->typeConverter->getType($range);
        if (!$dataType) {
            if (null !== ($unionOf = $range->get('owl:unionOf'))) {
                return $this->getRanges($unionOf, $propertyConfig, $config);
            }

            if (null !== ($rdfFirst = $range->get('rdf:first'))) {
                $ranges = $this->getRanges($rdfFirst, $propertyConfig, $config);
                if (null !== ($rdfRest = $range->get('rdf:rest'))) {
                    $ranges = array_merge($ranges, $this->getRanges($rdfRest, $propertyConfig, $config));
                }

                return $ranges;
            }
        }

        if (
            (!isset($propertyConfig['range']) || $propertyConfig['range'] === $localName)
            && (empty($config['types']) || isset($config['types'][$localName]) || $dataType)
        ) {
            return [$range];
        }

        return [];
    }
}
