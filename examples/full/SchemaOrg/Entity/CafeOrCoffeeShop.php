<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A cafe or coffee shop.
 * 
 * @see http://schema.org/CafeOrCoffeeShop Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CafeOrCoffeeShop extends FoodEstablishment
{
}
