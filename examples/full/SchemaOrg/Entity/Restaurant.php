<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A restaurant.
 * 
 * @see http://schema.org/Restaurant Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Restaurant extends FoodEstablishment
{
}
