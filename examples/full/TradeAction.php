<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trade Action
 * 
 * @link http://schema.org/TradeAction
 * 
 * @ORM\MappedSuperclass
 */
class TradeAction extends Action
{
    /**
     * Price
     * 
     * @var string $price The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $price;
}
