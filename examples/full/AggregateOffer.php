<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Aggregate Offer
 * 
 * @link http://schema.org/AggregateOffer
 * 
 * @ORM\Entity
 */
class AggregateOffer extends Offer
{
    /**
     * High Price
     * 
     * @var float $highPrice The highest price of all offers available.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $highPrice;
    /**
     * Low Price
     * 
     * @var float $lowPrice The lowest price of all offers available.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $lowPrice;
    /**
     * Offer Count
     * 
     * @var integer $offerCount The number of offers for the product.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $offerCount;
}
