<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A fast-food restaurant.
 * 
 * @see http://schema.org/FastFoodRestaurant Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FastFoodRestaurant extends FoodEstablishment
{
}
