<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A place offering space for "Recreational Vehicles", Caravans, mobile homes and the like.
 * 
 * @see http://schema.org/RVPark Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RVPark extends CivicStructure
{
}
