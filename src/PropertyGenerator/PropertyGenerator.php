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
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use EasyRdf\Resource as RdfResource;
use Psr\Log\LoggerInterface;

final class PropertyGenerator
{
    /** @var string[] */
    private static array $rangeProperties = [
        'schema:rangeIncludes',
        'rdfs:range',
    ];

    private GoodRelationsBridge $goodRelationsBridge;
    private LoggerInterface $logger;
    private PhpTypeConverterInterface $phpTypeConverter;
    /** @var array<string, string> */
    private array $cardinalities;

    /**
     * @param array<string, string> $cardinalities
     */
    public function __construct(GoodRelationsBridge $goodRelationsBridge, PhpTypeConverterInterface $phpTypeConverter, $cardinalities, LoggerInterface $logger)
    {
        $this->goodRelationsBridge = $goodRelationsBridge;
        $this->phpTypeConverter = $phpTypeConverter;
        $this->cardinalities = $cardinalities;
        $this->logger = $logger;
    }

    /**
     * @param Configuration      $config
     * @param ?TypeConfiguration $typeConfig
     */
    public function __invoke(array $config, Class_ $class, RdfResource $type, ?array $typeConfig, RdfResource $property, bool $isCustom = false): Class_
    {
        $typeUri = $type->getUri();
        $propertyName = $property->localName();
        $propertyUri = $property->getUri();

        // Warn when property are not part of GoodRelations
        if ($config['checkIsGoodRelations'] && !$this->goodRelationsBridge->exists($propertyName)) {
            $this->logger->warning(sprintf('The property "%s" (type "%s") is not part of GoodRelations.', $propertyUri, $typeUri));
        }

        // Warn when properties are legacy
        if (preg_match('/legacy spelling/', (string) $property->get('rdfs:comment'))) {
            $this->logger->warning(sprintf('The property "%s" (type "%s") is legacy.', $propertyUri, $typeUri));
        }

        $propertyConfig = $typeConfig['properties'][$propertyName] ?? [];

        $ranges = [];
        foreach (self::$rangeProperties as $rangePropertyType) {
            /** @var RdfResource $range */
            foreach ($property->all($rangePropertyType, 'resource') as $range) {
                $ranges[] = $this->getRanges($range, $propertyConfig, $config);
            }
        }
        $ranges = array_merge(...$ranges);

        if (!$ranges) {
            if (isset($propertyConfig['range'])) {
                $ranges[] = new RdfResource($propertyConfig['range'], $type->getGraph());
            } else {
                $this->logger->error(sprintf('The property "%s" (type "%s") has an unknown type. Add its type to the config file.', $propertyUri, $typeUri));
            }
        }

        if (\count($ranges) > 1) {
            $this->logger->warning(sprintf('The property "%s" (type "%s") has several types. Using the first one ("%s"). Other possible options: "%s".', $propertyUri, $typeUri, $ranges[0]->getUri(), implode('", "', array_map(static fn (RdfResource $range) => $range->getUri(), $ranges))));
        }

        $rangeName = null;
        $range = null;
        if (isset($ranges[0])) {
            $range = $ranges[0];
            if (!isset($propertyConfig['range']) && $mappedUri = ($config['rangeMapping'][$ranges[0]->getUri()] ?? false)) {
                $range = new RdfResource($mappedUri);
            }

            $rangeName = $this->phpTypeConverter->escapeIdentifier($range->localName());
        }

        if (!$ranges) {
            return $class;
        }

        $cardinality = $propertyConfig['cardinality'] ?? false;
        if (!$cardinality || CardinalitiesExtractor::CARDINALITY_UNKNOWN === $cardinality) {
            $cardinality = $this->cardinalities[$propertyUri] ?? CardinalitiesExtractor::CARDINALITY_1_1;
        }

        $isArray = \in_array($cardinality, [
            CardinalitiesExtractor::CARDINALITY_0_N,
            CardinalitiesExtractor::CARDINALITY_1_N,
            CardinalitiesExtractor::CARDINALITY_N_N,
        ], true);

        $isNullable = (bool) ($propertyConfig['nullable'] ?? !\in_array($cardinality, [
            CardinalitiesExtractor::CARDINALITY_1_1,
            CardinalitiesExtractor::CARDINALITY_1_N,
        ], true));

        $columnPrefix = false;
        $isEmbedded = $propertyConfig['embedded'] ?? false;

        if (true === $isEmbedded) {
            $columnPrefix = $propertyConfig['columnPrefix'] ?? false;
        }

        $schemaGeneratorProperty = new Property($propertyName);
        $schemaGeneratorProperty->resource = $property;
        $schemaGeneratorProperty->rangeName = $rangeName;
        $schemaGeneratorProperty->range = $range;
        $schemaGeneratorProperty->cardinality = $cardinality;
        $schemaGeneratorProperty->ormColumn = $propertyConfig['ormColumn'] ?? null;
        $schemaGeneratorProperty->isArray = $isArray;
        $schemaGeneratorProperty->isReadable = $propertyConfig['readable'] ?? true;
        $schemaGeneratorProperty->isWritable = $propertyConfig['writable'] ?? true;
        $schemaGeneratorProperty->isNullable = $isNullable;
        $schemaGeneratorProperty->isUnique = $propertyConfig['unique'] ?? false;
        $schemaGeneratorProperty->isCustom = $isCustom;
        $schemaGeneratorProperty->isEmbedded = $isEmbedded;
        $schemaGeneratorProperty->columnPrefix = $columnPrefix;
        $schemaGeneratorProperty->mappedBy = $propertyConfig['mappedBy'] ?? null;
        $schemaGeneratorProperty->inversedBy = $propertyConfig['inversedBy'] ?? null;
        $schemaGeneratorProperty->groups = $propertyConfig['groups'] ?? [];
        $schemaGeneratorProperty->security = $propertyConfig['security'] ?? null;
        $schemaGeneratorProperty->isId = false;
        $class->addProperty($schemaGeneratorProperty);

        if ($isArray) {
            $class->hasConstructor = true;

            if ($config['doctrine']['useCollection']) {
                $class->addUse(new Use_(ArrayCollection::class));
                $class->addUse(new Use_(Collection::class));
            }
        }

        return $class;
    }

    /**
     * @param PropertyConfiguration|array{} $propertyConfig
     * @param Configuration $config
     *
     * @return RdfResource[]
     */
    private function getRanges(RdfResource $range, array $propertyConfig, array $config): array
    {
        $localName = $range->localName();
        $dataType = $this->phpTypeConverter->isDatatype($range);
        $ranges = [];
        if (!$dataType && $range->isBNode()) {
            if (null !== ($unionOf = $range->get('owl:unionOf'))) {
                return $this->getRanges($unionOf, $propertyConfig, $config);
            }

            if (null !== ($rdfFirst = $range->get('rdf:first'))) {
                $ranges = $this->getRanges($rdfFirst, $propertyConfig, $config);
                if (null !== ($rdfRest = $range->get('rdf:rest'))) {
                    $ranges = array_merge($ranges, $this->getRanges($rdfRest, $propertyConfig, $config));
                }
            }

            return $ranges;
        }

        if (
            (!isset($propertyConfig['range']) || $propertyConfig['range'] === $localName) &&
            (empty($config['types']) || isset($config['types'][$localName]) || $dataType)
        ) {
            return [$range];
        }

        return [];
    }
}
