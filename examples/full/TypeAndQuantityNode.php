<?php

namespace SchemaOrg;

/**
 * Type And Quantity Node
 *
 * @link http://schema.org/TypeAndQuantityNode
 */
class TypeAndQuantityNode extends StructuredValue
{
    /**
     * Amount of This Good
     *
     * @var float The quantity of the goods included in the offer.
     */
    protected $amountOfThisGood;
    /**
     * Business Function
     *
     * @var BusinessFunction The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.
     */
    protected $businessFunction;
    /**
     * Type of Good
     *
     * @var Product The product that this structured value is referring to.
     */
    protected $typeOfGood;
    /**
     * Unit Code
     *
     * @var string The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     */
    protected $unitCode;
}
