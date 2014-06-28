<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bakery
 * 
 * @link http://schema.org/Bakery
 * 
 * @ORM\Entity
 */
class Bakery extends FoodEstablishment
{
}
