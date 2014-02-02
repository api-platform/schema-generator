<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel;

/**
 * Cardinality extractor
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class CardinalitiesExtractor
{
    const CARDINALITY_0_1 = '(0..1)';
    const CARDINALITY_0_N = '(0..*)';
    const CARDINALITY_1_1 = '(1..1)';
    const CARDINALITY_1_N = '(1..*)';

    /**
     * @var \stdClass
     */
    protected $schemaOrg;
    /**
     * @var GoodRelationsBridge
     */
    protected $goodRelationsBridge;

    /**
     * @param \stdClass           $schemaOrg
     * @param GoodRelationsBridge $goodRelationsBridge
     * @internal param \SimpleXMLElement $goodRelations
     */
    public function __construct(\stdClass $schemaOrg, GoodRelationsBridge $goodRelationsBridge)
    {
        $this->schemaOrg = $schemaOrg;
        $this->goodRelationsBridge = $goodRelationsBridge;
    }

    /**
     * Extracts cardinality of properties
     *
     * @return array
     */
    public function extract()
    {
        $properties = [];

        foreach ($this->schemaOrg->properties as $property) {
            $properties[$property->id] = $this->extractForProperty($property);
        }

        return $properties;
    }

    /**
     * Extracts the cardinality of a property
     * Based on Geraint Luff work: https://github.com/geraintluff/schema-org-gen
     *
     * @param  \stdClass $property
     * @return string    The cardinality
     */
    private function extractForProperty(\stdClass $property)
    {
        $fromGoodRelations = $this->goodRelationsBridge->extractCardinality($property->id);
        if ($fromGoodRelations) {
            return $fromGoodRelations;
        }

        $id = $property->id;
        $comment = $property->comment_plain;

        if (
            // http://schema.org/acceptedOffer, http://schema.org/acceptedPaymentMethod, http://schema.org/exerciseType
            preg_match('/^\(s\)/', $comment)
            ||
            // http://schema.org/follows
            preg_match('/^The most generic uni-directional social relation./', $comment)
            ||
            preg_match('/An? /', $comment)
            ||
            preg_match('/one or more/i', $comment)
        ) {
            return self::CARDINALITY_0_N;
        }

        if (
            preg_match('/^is/', $id)
        ||
            preg_match('/^The /', $comment)
        ) {
            return self::CARDINALITY_1_N;
        }

        return 'unknown';
    }

}
