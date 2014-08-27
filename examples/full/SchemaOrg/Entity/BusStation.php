<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A bus station.
 * 
 * @see http://schema.org/BusStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BusStation extends CivicStructure
{
}
