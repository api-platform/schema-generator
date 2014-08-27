<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A common pathway for the electrochemical nerve impulses that are transmitted along each of the axons.
 * 
 * @see http://schema.org/Nerve Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Nerve extends AnatomicalStructure
{
    /**
     * @type AnatomicalStructure $branch The branches that delineate from the nerve bundle.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $branch;
    /**
     * @type Muscle $nerveMotor The neurological pathway extension that involves muscle control.
     * @ORM\ManyToOne(targetEntity="Muscle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nerveMotor;
    /**
     * @type AnatomicalStructure $sensoryUnit The neurological pathway extension that inputs and sends information to the brain or spinal cord.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sensoryUnit;
    /**
     * @type BrainStructure $sourcedFrom The neurological pathway that originates the neurons.
     * @ORM\ManyToOne(targetEntity="BrainStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sourcedFrom;
}
