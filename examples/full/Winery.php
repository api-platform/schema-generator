<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Winery
 * 
 * @link http://schema.org/Winery
 * 
 * @ORM\Entity
 */
class Winery extends FoodEstablishment
{
}
