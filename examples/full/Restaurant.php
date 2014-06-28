<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 * 
 * @link http://schema.org/Restaurant
 * 
 * @ORM\Entity
 */
class Restaurant extends FoodEstablishment
{
}
