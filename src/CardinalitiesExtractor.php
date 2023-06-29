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

namespace ApiPlatform\SchemaGenerator;

use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;

/**
 * Extracts cardinalities from the OWL definition, from GoodRelations or from Schema.org's comments.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class CardinalitiesExtractor
{
    public const CARDINALITY_0_1 = '(0..1)';
    public const CARDINALITY_0_N = '(0..*)';
    public const CARDINALITY_1_1 = '(1..1)';
    public const CARDINALITY_1_N = '(1..*)';
    public const CARDINALITY_N_0 = '(*..0)';
    public const CARDINALITY_N_1 = '(*..1)';
    public const CARDINALITY_N_N = '(*..*)';
    public const CARDINALITY_UNKNOWN = 'unknown';

    private GoodRelationsBridge $goodRelationsBridge;

    public function __construct(GoodRelationsBridge $goodRelationsBridge)
    {
        $this->goodRelationsBridge = $goodRelationsBridge;
    }

    /**
     * Extracts cardinality of properties.
     *
     * @param RdfGraph[] $graphs
     *
     * @return array<string, string>
     */
    public function extract(array $graphs): array
    {
        $properties = [];

        foreach ($graphs as $graph) {
            foreach (TypesGenerator::$propertyTypes as $propertyType) {
                /** @var RdfResource $property */
                foreach ($graph->allOfType($propertyType) as $property) {
                    if ($property->isBNode()) {
                        continue;
                    }

                    $properties[$property->getUri()] = $this->extractForProperty($property);
                }
            }
        }

        return $properties;
    }

    /**
     * Extracts the cardinality of a property.
     *
     * Based on [Geraint Luff work](https://github.com/geraintluff/schema-org-gen).
     *
     * @return string The cardinality
     */
    private function extractForProperty(RdfResource $property): string
    {
        $minCardinality = $property->get('owl:minCardinality');
        $maxCardinality = $property->get('owl:maxCardinality');
        if (null !== $minCardinality && null !== $maxCardinality && $minCardinality >= 1 && $maxCardinality <= 1) {
            return self::CARDINALITY_1_1;
        }

        if ((null !== $minCardinality) && $minCardinality >= 1) {
            return self::CARDINALITY_1_N;
        }

        if ((null !== $maxCardinality) && $maxCardinality <= 1) {
            return self::CARDINALITY_0_1;
        }

        if ($property->isA('owl:FunctionalProperty')) {
            return self::CARDINALITY_0_1;
        }
        if ($property->isA('owl:InverseFunctionalProperty')) {
            return self::CARDINALITY_0_N;
        }

        if (!str_starts_with($property->getUri(), 'https://schema.org')) {
            return self::CARDINALITY_UNKNOWN;
        }

        if (!\is_string($localName = $property->localName())) {
            return self::CARDINALITY_UNKNOWN;
        }

        $fromGoodRelations = $this->goodRelationsBridge->extractCardinality($localName);
        if (false !== $fromGoodRelations) {
            return $fromGoodRelations;
        }

        if (!$rdfsComment = $property->get('rdfs:comment')) {
            return self::CARDINALITY_UNKNOWN;
        }
        $comment = $rdfsComment->getValue();

        if (
            // https://schema.org/acceptedOffer, https://schema.org/acceptedPaymentMethod, https://schema.org/exerciseType
            preg_match('/\(s\)/', $comment)
            // https://schema.org/follows
            || preg_match('/^The most generic uni-directional social relation./', $comment)
            || preg_match('/one or more/i', $comment)
        ) {
            return self::CARDINALITY_0_N;
        }

        if (
            preg_match('/^is/', $localName)
            || preg_match('/^The /', $comment)
        ) {
            return self::CARDINALITY_0_1;
        }

        return self::CARDINALITY_UNKNOWN;
    }
}
