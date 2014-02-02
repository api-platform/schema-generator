<?php

namespace SchemaOrg;

/**
 * Unit Price Specification
 *
 * @link http://schema.org/UnitPriceSpecification
 */
class UnitPriceSpecification extends PriceSpecification
{
    /**
     * Billing Increment
     *
     * @var float This property specifies the minimal quantity and rounding increment that will be the basis for the billing. The unit of measurement is specified by the unitCode property.
     */
    protected $billingIncrement;
    /**
     * Price Type
     *
     * @var string A short text or acronym indicating multiple price specifications for the same offer, e.g. SRP for the suggested retail price or INVOICE for the invoice price, mostly used in the car industry.
     */
    protected $priceType;
    /**
     * Unit Code
     *
     * @var string The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     */
    protected $unitCode;
}
