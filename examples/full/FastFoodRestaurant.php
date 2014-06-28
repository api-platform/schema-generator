<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fast Food Restaurant
 * 
 * @link http://schema.org/FastFoodRestaurant
 * 
 * @ORM\Entity
 */
class FastFoodRestaurant extends FoodEstablishment
{
}
