<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A subway station.
 * 
 * @see http://schema.org/SubwayStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SubwayStation extends CivicStructure
{
}
