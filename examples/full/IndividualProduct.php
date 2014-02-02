<?php

namespace SchemaOrg;

/**
 * Individual Product
 *
 * @link http://schema.org/IndividualProduct
 */
class IndividualProduct extends Product
{
    /**
     * Serial Number
     *
     * @var string The serial number or any alphanumeric identifier of a particular product. When attached to an offer, it is a shortcut for the serial number of the product included in the offer.
     */
    protected $serialNumber;
}
