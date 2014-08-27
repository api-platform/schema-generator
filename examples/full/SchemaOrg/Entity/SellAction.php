<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of taking money from a buyer in exchange for goods or services rendered. An agent sells an object, product, or service to a buyer for a price. Reciprocal of BuyAction.
 * 
 * @see http://schema.org/SellAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SellAction extends TradeAction
{
    /**
     * @type Person $buyer A sub property of participant. The participant/person/organization that bought the object.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $buyer;
    /**
     * @type WarrantyPromise $warrantyPromise The warranty promise(s) included in the offer.
     * @ORM\ManyToOne(targetEntity="WarrantyPromise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warrantyPromise;
}
