<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brewery
 * 
 * @link http://schema.org/Brewery
 * 
 * @ORM\Entity
 */
class Brewery extends FoodEstablishment
{
}
