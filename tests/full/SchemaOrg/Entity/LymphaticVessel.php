<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A type of blood vessel that specifically carries lymph fluid unidirectionally toward the heart.
 * 
 * @see http://schema.org/LymphaticVessel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LymphaticVessel extends Vessel
{
    /**
     */
    private $originatesFrom;
    /**
     */
    private $regionDrained;
    /**
     */
    private $runsTo;
}
