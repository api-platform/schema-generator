<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A bakery.
 * 
 * @see http://schema.org/Bakery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Bakery extends FoodEstablishment
{
}
