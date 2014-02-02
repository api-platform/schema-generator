<?php

namespace SchemaOrg;

/**
 * Trade Action
 *
 * @link http://schema.org/TradeAction
 */
class TradeAction extends Action
{
    /**
     * Price (Text)
     *
     * @var string The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     */
    protected $priceText;
    /**
     * Price (Number)
     *
     * @var float The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     */
    protected $priceNumber;
}
