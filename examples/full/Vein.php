<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vein
 * 
 * @link http://schema.org/Vein
 * 
 * @ORM\Entity
 */
class Vein extends Vessel
{
    /**
     * Drains to
     * 
     * @var Vessel $drainsTo The vasculature that the vein drains into.
     * 
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $drainsTo;
    /**
     * Region Drained
     * 
     * @var AnatomicalSystem $regionDrained The anatomical or organ system drained by this vessel; generally refers to a specific part of an organ.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalSystem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regionDrained;
    /**
     * Tributary
     * 
     * @var AnatomicalStructure $tributary The anatomical or organ system that the vein flows into; a larger structure that the vein connects to.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tributary;
}
