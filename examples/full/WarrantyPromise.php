<?php

namespace SchemaOrg;

/**
 * Warranty Promise
 *
 * @link http://schema.org/WarrantyPromise
 */
class WarrantyPromise extends StructuredValue
{
    /**
     * Duration of Warranty
     *
     * @var QuantitativeValue The duration of the warranty promise. Common unitCode values are ANN for year, MON for months, or DAY for days.
     */
    protected $durationOfWarranty;
    /**
     * Warranty Scope
     *
     * @var WarrantyScope The scope of the warranty promise.
     */
    protected $warrantyScope;
}
