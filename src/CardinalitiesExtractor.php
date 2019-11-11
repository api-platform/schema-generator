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

/**
 * Cardinality extractor.
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
     * @var \EasyRdf_Graph[]
     */
    private $graphs;

    private $goodRelationsBridge;

    /**
     * @param \EasyRdf_Graph[] $graphs
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
            foreach ($graph->allOfType('rdf:Property') as $property) {
                $properties[$property->localName()] = $this->extractForProperty($property);
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
    private function extractForProperty(\EasyRdf_Resource $property): string
    {
        $localName = $property->localName();
        $fromGoodRelations = $this->goodRelationsBridge->extractCardinality($localName);
        if (false !== $fromGoodRelations) {
            return $fromGoodRelations;
        }

        $comment = $property->get('rdfs:comment')->getValue();

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
