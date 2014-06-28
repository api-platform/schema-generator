<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lymphatic Vessel
 * 
 * @link http://schema.org/LymphaticVessel
 * 
 * @ORM\Entity
 */
class LymphaticVessel extends Vessel
{
    /**
     * Originates From
     * 
     * @var Vessel $originatesFrom The vasculature the lymphatic structure originates, or afferents, from.
     * 
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $originatesFrom;
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
     * Runs to
     * 
     * @var Vessel $runsTo The vasculature the lymphatic structure runs, or efferents, to.
     * 
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $runsTo;
}
