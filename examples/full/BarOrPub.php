<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bar or Pub
 * 
 * @link http://schema.org/BarOrPub
 * 
 * @ORM\Entity
 */
class BarOrPub extends FoodEstablishment
{
}
