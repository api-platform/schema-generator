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
 * Schema.org to GoodRelations bridge.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class GoodRelationsBridge
{
    private const GOOD_RELATIONS_NAMESPACE = 'http://purl.org/goodrelations/v1#';
    private const RDF_SCHEMA_NAMESPACE = 'http://www.w3.org/2000/01/rdf-schema#';

    /**
     * @var \SimpleXMLElement[]
     */
    private array $relations;

    /** @var array<string, string> */
    private array $objectPropertiesTable = [
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

    /** @var array<string, string> */
    private array $datatypePropertiesTable = [
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
            $relation->registerXPathNamespace('rdfs', self::RDF_SCHEMA_NAMESPACE);
        }
    }

    /**
     * Checks if a property exists in GoodRelations.
     */
    public function exists(string $id): bool
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
     * @return string|false
     */
    public function extractCardinality(string $id)
    {
        foreach ($this->relations as $relation) {
            $result = $relation->xpath(sprintf('//*[@rdf:about="%s"]/rdfs:label', $this->getPropertyUrl($id)));
            if (!$result) {
                continue;
            }

            $xmlResult = $result[0]->asXML();
            if (false === $xmlResult) {
                continue;
            }
            preg_match('/\(.\.\..\)/', $xmlResult, $matches);

            return $matches[0];
        }

        return false;
    }

    /**
     * Gets a property URL.
     */
    private function getPropertyUrl(string $id): string
    {
        $propertyId = $this->datatypePropertiesTable[$id] ?? $this->objectPropertiesTable[$id] ?? $id;

        return self::GOOD_RELATIONS_NAMESPACE.$propertyId;
    }
}
