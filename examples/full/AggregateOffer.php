<?php

namespace SchemaOrg;

/**
 * Aggregate Offer
 *
 * @link http://schema.org/AggregateOffer
 */
class AggregateOffer extends Offer
{
    /**
     * High Price (Number)
     *
     * @var float The highest price of all offers available.
     */
    protected $highPriceNumber;
    /**
     * High Price (Text)
     *
     * @var string The highest price of all offers available.
     */
    protected $highPriceText;
    /**
     * Low Price (Number)
     *
     * @var float The lowest price of all offers available.
     */
    protected $lowPriceNumber;
    /**
     * Low Price (Text)
     *
     * @var string The lowest price of all offers available.
     */
    protected $lowPriceText;
    /**
     * Offer Count
     *
     * @var integer The number of offers for the product.
     */
    protected $offerCount;
}
