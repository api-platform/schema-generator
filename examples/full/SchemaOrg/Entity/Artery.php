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
     * @type AnatomicalStructure $arterialBranch The branches that comprise the arterial structure.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arterialBranch;
    /**
     * @type AnatomicalStructure $source The anatomical or organ system that the artery originates from.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;
    /**
     * @type AnatomicalStructure $supplyTo The area to which the artery supplies blood.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplyTo;
}
