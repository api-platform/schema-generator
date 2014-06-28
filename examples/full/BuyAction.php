<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Buy Action
 * 
 * @link http://schema.org/BuyAction
 * 
 * @ORM\Entity
 */
class BuyAction extends TradeAction
{
    /**
     * Vendor
     * 
     * @var Organization $vendor A sub property of participant. The seller.The participant/person/organization that sold the object.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $vendor;
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
