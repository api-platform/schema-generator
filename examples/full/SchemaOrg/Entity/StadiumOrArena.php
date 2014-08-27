<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A stadium.
 * 
 * @see http://schema.org/StadiumOrArena Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class StadiumOrArena extends CivicStructure
{
}
