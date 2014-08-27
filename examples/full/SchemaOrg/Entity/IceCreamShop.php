<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An ice cream shop
 * 
 * @see http://schema.org/IceCreamShop Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class IceCreamShop extends FoodEstablishment
{
}
