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
     * @type Vessel $originatesFrom The vasculature the lymphatic structure originates, or afferents, from.
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $originatesFrom;
    /**
     * @type AnatomicalStructure $regionDrained The anatomical or organ system drained by this vessel; generally refers to a specific part of an organ.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regionDrained;
    /**
     * @type Vessel $runsTo The vasculature the lymphatic structure runs, or efferents, to.
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $runsTo;
}
