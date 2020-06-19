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

use EasyRdf\Graph;
use EasyRdf\Resource;

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

    /**
     * @var Graph[]
     */
    private array $graphs;
    private GoodRelationsBridge $goodRelationsBridge;

    /**
     * @param Graph[] $graphs
     */
    public function __construct(array $graphs, GoodRelationsBridge $goodRelationsBridge)
    {
        $this->graphs = $graphs;
        $this->goodRelationsBridge = $goodRelationsBridge;
    }

    /**
     * Extracts cardinality of properties.
     */
    public function extract(): array
    {
        $properties = [];

        foreach ($this->graphs as $graph) {
            foreach (TypesGenerator::$propertyTypes as $propertyType) {
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
    private function extractForProperty(Resource $property): string
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

        if (0 !== strpos($property->getUri(), 'http://schema.org')) {
            return self::CARDINALITY_UNKNOWN;
        }

        $localName = $property->localName();
        $fromGoodRelations = $this->goodRelationsBridge->extractCardinality($localName);
        if (false !== $fromGoodRelations) {
            return $fromGoodRelations;
        }

        if (!$rdfsComment = $property->get('rdfs:comment')) {
            return self::CARDINALITY_UNKNOWN;
        }
        $comment = $rdfsComment->getValue();

        if (
            // http://schema.org/acceptedOffer, http://schema.org/acceptedPaymentMethod, http://schema.org/exerciseType
            preg_match('/\(s\)/', $comment)
            ||
            // http://schema.org/follows
            preg_match('/^The most generic uni-directional social relation./', $comment)
            ||
            preg_match('/one or more/i', $comment)
        ) {
            return self::CARDINALITY_0_N;
        }

        if (
            preg_match('/^is/', $localName)
        ||
            preg_match('/^The /', $comment)
        ) {
            return self::CARDINALITY_0_1;
        }

        return self::CARDINALITY_UNKNOWN;
    }
}
