<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A parking lot or other parking facility.
 * 
 * @see http://schema.org/ParkingFacility Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ParkingFacility extends CivicStructure
{
}
