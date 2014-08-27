<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A winery.
 * 
 * @see http://schema.org/Winery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Winery extends FoodEstablishment
{
}
