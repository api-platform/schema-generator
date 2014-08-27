<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A placeholder for multiple similar products of the same kind.
 * 
 * @see http://schema.org/SomeProducts Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SomeProducts extends Product
{
    /**
     * @type QuantitativeValue $inventoryLevel The current approximate inventory level for the item or items.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $inventoryLevel;
}
