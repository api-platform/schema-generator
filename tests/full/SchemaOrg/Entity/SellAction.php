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
     */
    private $buyer;
    /**
     */
    private $warrantyPromise;
}
