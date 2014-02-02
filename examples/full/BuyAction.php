<?php

namespace SchemaOrg;

/**
 * Buy Action
 *
 * @link http://schema.org/BuyAction
 */
class BuyAction extends TradeAction
{
    /**
     * Vendor (Organization)
     *
     * @var Organization A sub property of participant. The seller.The participant/person/organization that sold the object.
     */
    protected $vendorOrganization;
    /**
     * Vendor (Person)
     *
     * @var Person A sub property of participant. The seller.The participant/person/organization that sold the object.
     */
    protected $vendorPerson;
    /**
     * Warranty Promise
     *
     * @var WarrantyPromise The warranty promise(s) included in the offer.
     */
    protected $warrantyPromise;
}
