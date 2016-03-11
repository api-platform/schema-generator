<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator;

/**
 * Cardinality extractor.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class CardinalitiesExtractor
{
    const CARDINALITY_0_1 = '(0..1)';
    const CARDINALITY_0_N = '(0..*)';
    const CARDINALITY_1_1 = '(1..1)';
    const CARDINALITY_1_N = '(1..*)';
    const CARDINALITY_N_0 = '(*..0)';
    const CARDINALITY_N_1 = '(*..1)';
    const CARDINALITY_N_N = '(*..*)';
    const CARDINALITY_UNKNOWN = 'unknown';

    /**
     * @var \EasyRdf_Graph[]
     */
    private $graphs;
    /**
     * @var GoodRelationsBridge
     */
    private $goodRelationsBridge;

    /**
     * @param \EasyRdf_Graph[]    $graphs
     * @param GoodRelationsBridge $goodRelationsBridge
     */
    public function __construct(array $graphs, GoodRelationsBridge $goodRelationsBridge)
    {
        $this->graphs = $graphs;
        $this->goodRelationsBridge = $goodRelationsBridge;
    }

    /**
     * Extracts cardinality of properties.
     *
     * @return array
     */
    public function extract()
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
     * @param \EasyRdf_Resource $property
     *
     * @return string The cardinality
     */
    private function extractForProperty(\EasyRdf_Resource $property)
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
