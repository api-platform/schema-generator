<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * City Hall
 * 
 * @link http://schema.org/CityHall
 * 
 * @ORM\Entity
 */
class CityHall extends GovernmentBuilding
{
}
