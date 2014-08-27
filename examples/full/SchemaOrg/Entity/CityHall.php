<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A city hall.
 * 
 * @see http://schema.org/CityHall Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CityHall extends GovernmentBuilding
{
}
