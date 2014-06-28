<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Nerve
 * 
 * @link http://schema.org/Nerve
 * 
 * @ORM\Entity
 */
class Nerve extends AnatomicalStructure
{
    /**
     * Branch
     * 
     * @var AnatomicalStructure $branch The branches that delineate from the nerve bundle.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $branch;
    /**
     * Nerve Motor
     * 
     * @var Muscle $nerveMotor The neurological pathway extension that involves muscle control.
     * 
     * @ORM\ManyToOne(targetEntity="Muscle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nerveMotor;
    /**
     * Sensory Unit
     * 
     * @var AnatomicalStructure $sensoryUnit The neurological pathway extension that inputs and sends information to the brain or spinal cord.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sensoryUnit;
    /**
     * Sourced From
     * 
     * @var BrainStructure $sourcedFrom The neurological pathway that originates the neurons.
     * 
     * @ORM\ManyToOne(targetEntity="BrainStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sourcedFrom;
}
