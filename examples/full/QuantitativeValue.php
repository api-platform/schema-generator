<?php

namespace SchemaOrg;

/**
 * Quantitative Value
 *
 * @link http://schema.org/QuantitativeValue
 */
class QuantitativeValue extends StructuredValue
{
    /**
     * Max Value
     *
     * @var float The upper of the product characteristic.
     */
    protected $maxValue;
    /**
     * Min Value
     *
     * @var float The lower value of the product characteristic.
     */
    protected $minValue;
    /**
     * Unit Code
     *
     * @var string The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     */
    protected $unitCode;
    /**
     * Value
     *
     * @var float The value of the product characteristic.
     */
    protected $value;
    /**
     * Value Reference (Enumeration)
     *
     * @var Enumeration A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     */
    protected $valueReferenceEnumeration;
    /**
     * Value Reference (StructuredValue)
     *
     * @var StructuredValue A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     */
    protected $valueReferenceStructuredValue;
}
