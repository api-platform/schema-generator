<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Some Products
 * 
 * @link http://schema.org/SomeProducts
 * 
 * @ORM\Entity
 */
class SomeProducts extends Product
{
    /**
     * Inventory Level
     * 
     * @var QuantitativeValue $inventoryLevel The current approximate inventory level for the item or items.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $inventoryLevel;
}
