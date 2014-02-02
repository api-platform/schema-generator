<?php

namespace SchemaOrg;

/**
 * Delivery Charge Specification
 *
 * @link http://schema.org/DeliveryChargeSpecification
 */
class DeliveryChargeSpecification extends PriceSpecification
{
    /**
     * Applies to Delivery Method
     *
     * @var DeliveryMethod The delivery method(s) to which the delivery charge or payment charge specification applies.
     */
    protected $appliesToDeliveryMethod;
    /**
     * Eligible Region (Text)
     *
     * @var string The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     */
    protected $eligibleRegionText;
    /**
     * Eligible Region (GeoShape)
     *
     * @var GeoShape The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     */
    protected $eligibleRegionGeoShape;
}
