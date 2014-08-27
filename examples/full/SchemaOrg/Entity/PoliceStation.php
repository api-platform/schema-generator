<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A police station.
 * 
 * @see http://schema.org/PoliceStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PoliceStation extends CivicStructure
{
}
