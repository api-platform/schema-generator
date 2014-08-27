<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * When a single product is associated with multiple offers (for example, the same pair of shoes is offered by different merchants), then AggregateOffer can be used.
 * 
 * @see http://schema.org/AggregateOffer Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AggregateOffer extends Offer
{
    /**
     * @type float $highPrice The highest price of all offers available.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $highPrice;
    /**
     * @type float $lowPrice The lowest price of all offers available.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $lowPrice;
    /**
     * @type integer $offerCount The number of offers for the product.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $offerCount;
}
