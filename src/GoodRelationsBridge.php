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
 * Schema.org to GoodRelations bridge.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class GoodRelationsBridge
{
    const GOOD_RELATIONS_NAMESPACE = 'http://purl.org/goodrelations/v1#';
    const RDF_SCHEMA_NAMESPACE = 'http://www.w3.org/2000/01/rdf-schema#';

    /**
     * @var \SimpleXMLElement[]
     */
    protected $relations;

    /**
     * @var array
     */
    protected static $objectPropertiesTable = [
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
        'acceptedPaymentMethod' => 'acceptedPaymentMethods',
    ];
    /**
     * @var array
     */
    protected static $datatypePropertiesTable = [
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
        'eligibleRegion' => 'eligibleRegions',
    ];

    /**
     * @param \SimpleXMLElement[] $relations
     */
    public function __construct(array $relations)
    {
        $this->relations = $relations;

        foreach ($this->relations as $relation) {
            $relation->registerXPathNamespace('rdfs', static::RDF_SCHEMA_NAMESPACE);
        }
    }

    /**
     * Checks if a property exists in GoodRelations.
     *
     * @param string $id
     *
     * @return bool
     */
    public function exist($id)
    {
        foreach ($this->relations as $relation) {
            $result = $relation->xpath(sprintf('//*[@rdf:about="%s"]', $this->getPropertyUrl($id)));
            if (!empty($result)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extracts cardinality from the Good Relations OWL.
     *
     * @param string $id
     *
     * @return string|bool
     */
    public function extractCardinality($id)
    {
        foreach ($this->relations as $relation) {
            $result = $relation->xpath(sprintf('//*[@rdf:about="%s"]/rdfs:label', $this->getPropertyUrl($id)));
            if (count($result)) {
                preg_match('/\(.\.\..\)/', $result[0]->asXML(), $matches);

                return $matches[0];
            }
        }

        return false;
    }

    /**
     * Converts Schema.org's id to Good Relations id.
     *
     * @param string $id
     *
     * @return string
     */
    private function convertPropertyId($id)
    {
        if (isset(static::$datatypePropertiesTable[$id])) {
            return static::$datatypePropertiesTable[$id];
        }

        if (isset(static::$objectPropertiesTable[$id])) {
            return static::$objectPropertiesTable[$id];
        }

        return $id;
    }

    /**
     * Gets a property URL.
     *
     * @param string $id
     *
     * @return string
     */
    private function getPropertyUrl($id)
    {
        return self::GOOD_RELATIONS_NAMESPACE.$this->convertPropertyId($id);
    }
}
