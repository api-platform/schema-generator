<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cafe or Coffee Shop
 * 
 * @link http://schema.org/CafeOrCoffeeShop
 * 
 * @ORM\Entity
 */
class CafeOrCoffeeShop extends FoodEstablishment
{
}
