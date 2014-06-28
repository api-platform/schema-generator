<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sell Action
 * 
 * @link http://schema.org/SellAction
 * 
 * @ORM\Entity
 */
class SellAction extends TradeAction
{
    /**
     * Buyer
     * 
     * @var Person $buyer A sub property of participant. The participant/person/organization that bought the object.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $buyer;
    /**
     * Warranty Promise
     * 
     * @var WarrantyPromise $warrantyPromise The warranty promise(s) included in the offer.
     * 
     * @ORM\ManyToOne(targetEntity="WarrantyPromise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warrantyPromise;
}
