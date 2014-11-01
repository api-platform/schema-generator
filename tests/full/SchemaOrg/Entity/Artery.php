<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A type of blood vessel that specifically carries blood away from the heart.
 * 
 * @see http://schema.org/Artery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Artery extends Vessel
{
    /**
     */
    private $arterialBranch;
    /**
     */
    private $source;
    /**
     */
    private $supplyTo;
}
