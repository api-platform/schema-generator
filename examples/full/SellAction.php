<?php

namespace SchemaOrg;

/**
 * Sell Action
 *
 * @link http://schema.org/SellAction
 */
class SellAction extends TradeAction
{
    /**
     * Buyer
     *
     * @var Person A sub property of participant. The participant/person/organization that bought the object.
     */
    protected $buyer;
    /**
     * Warranty Promise
     *
     * @var WarrantyPromise The warranty promise(s) included in the offer.
     */
    protected $warrantyPromise;
}
