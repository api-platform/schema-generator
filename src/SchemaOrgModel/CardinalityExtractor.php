<?php

namespace SchemaOrgModel;

/**
 * Cardinality Extractor
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class CardinalityExtractor
{
    const CARDINALITY_0_1 = '(0..1)';
    const CARDINALITY_0_N = '(0..*)';
    const CARDINALITY_1_1 = '(1..1)';
    const CARDINALITY_1_N = '(1..*)';

    const GOOD_RELATIONS_NAMESPACE = 'http://purl.org/goodrelations/v1';

    /**
     * @var \stdClass
     */
    protected $schemaOrg;
    /**
     * @var \SimpleXMLElement
     */
    protected $goodRelations;
    /**
     * @var array
     */
    protected $goodRelationsObjectPropertiesTable = [
        'priceSpecification' => 'hasPriceSpecification',
        'businessFunction' => 'hasBusinessFunction',
        'eligibleCustomerType' => 'eligibleCustomerTypes',
        'manufacturer' => 'hasManufacturer',
        'warrantyScope' => 'hasWarrantyScope',
        'inventoryLevel' => 'hasInventoryLevel',
        'dayOfWeek' => 'hasOpeningHoursDayOfWeek',
        'brand' => 'hasBrand',
        'itemOffered' => 'includes',
        'makesOffer' => 'offers',
        'availableDeliveryMethod' => 'availableDeliveryMethods',
        'openingHoursSpecification' => 'hasOpeningHoursSpecification',
        'eligibleQuantity' => 'hasEligibleQuantity',
        'warranty' => 'hasWarrantyPromise',
        'acceptedPaymentMethod' => 'acceptedPaymentMethods'
    ];
    protected $goodRelationsDatatypePropertiesTable = [
        'minPrice' => 'hasMinCurrencyValue',
        'unitCode' => 'hasUnitOfMeasurement',
        'isicV4' => 'hasISICv4',
        'gtin8' => 'hasGTIN-8',
        'maxPrice' => 'hasMaxCurrencyValue',
        'gtin14' => 'hasGTIN-14',
        'maxValue' => 'hasMaxValue',
        'mpn' => 'hasMPN',
        'value' => 'hasValue',
        'model' => 'hasMakeAndModel',
        'gtin13' => 'hasEAN_UCC-13',
        'globalLocationNumber' => 'hasGlobalLocationNumber',
        'naics' => 'hasNAICS',
        'priceCurrency' => 'hasCurrency',
        'sku' => 'hasStockKeepingUnit',
        'duns' => 'hasDUNS',
        'minValue' => 'hasMinValue',
        'eligibleRegion' => 'eligibleRegions'
    ];

    /**
     * @param \stdClass $schemaOrg
     * @param \SimpleXMLElement $goodRelations
     */
    public function __construct(\stdClass $schemaOrg, \SimpleXMLElement $goodRelations)
    {
        $this->schemaOrg = $schemaOrg;
        $this->goodRelations = $goodRelations;
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
     * @param \stdClass $property
     * @return string The cardinality
     */
    private function extractForProperty(\stdClass $property)
    {
        $fromGoodRelations = $this->extractFromGoodRelations($property);
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

    /**
     * Extracts cardinality from the Good Relations OWL
     *
     * @param \stdClass $property
     * @return string|bool
     */
    private function extractFromGoodRelations(\stdClass $property)
    {
        $goodRelationsAbout = sprintf('%s#%s', self::GOOD_RELATIONS_NAMESPACE, $this->convertToGoodRelations($property->id));
        $this->goodRelations->registerXPathNamespace('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
        $result = $this->goodRelations->xpath(sprintf('//*[@rdf:about="%s"]/rdfs:label', $goodRelationsAbout));
        if (count($result)) {
            preg_match('/\(.\.\..\)/', $result[0]->asXML(), $matches);
            return $matches[0];
        }

        return false;
    }

    /**
     * Converts Schema.org's id to Good Relations id
     *
     * @param string $id
     * @return string
     */
    private function convertToGoodRelations($id)
    {
        if (isset ($this->goodRelationsDatatypePropertiesTable[$id])) {
            return $this->goodRelationsDatatypePropertiesTable[$id];
        }

        if (isset ($this->goodRelationsObjectPropertiesTable[$id])) {
            return $this->goodRelationsObjectPropertiesTable[$id];
        }

        return $id;
    }
} 