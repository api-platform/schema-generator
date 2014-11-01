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
     */
    private $highPrice;
    /**
     */
    private $lowPrice;
    /**
     */
    private $offerCount;
}
