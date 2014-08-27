<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of giving money to a seller in exchange for goods or services rendered. An agent buys an object, product, or service from a seller for a price. Reciprocal of SellAction.
 * 
 * @see http://schema.org/BuyAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BuyAction extends TradeAction
{
    /**
     * @type Organization $seller An entity which offers (sells / leases / lends / loans) the services / goods.  A seller may also be a provider.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $seller;
    /**
     * @type Organization $vendor 'vendor' is an earlier term for 'seller'.
     */
    private $vendor;
    /**
     * @type WarrantyPromise $warrantyPromise The warranty promise(s) included in the offer.
     * @ORM\ManyToOne(targetEntity="WarrantyPromise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warrantyPromise;
}
