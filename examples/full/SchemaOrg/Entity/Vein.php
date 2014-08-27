<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A type of blood vessel that specifically carries blood to the heart.
 * 
 * @see http://schema.org/Vein Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Vein extends Vessel
{
    /**
     * @type Vessel $drainsTo The vasculature that the vein drains into.
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $drainsTo;
    /**
     * @type AnatomicalStructure $regionDrained The anatomical or organ system drained by this vessel; generally refers to a specific part of an organ.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regionDrained;
    /**
     * @type AnatomicalStructure $tributary The anatomical or organ system that the vein flows into; a larger structure that the vein connects to.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tributary;
}
