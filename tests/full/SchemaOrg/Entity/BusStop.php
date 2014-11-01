<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A bus stop.
 * 
 * @see http://schema.org/BusStop Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BusStop extends CivicStructure
{
}
