<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brewery.
 * 
 * @see http://schema.org/Brewery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Brewery extends FoodEstablishment
{
}
