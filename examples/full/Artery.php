<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Artery
 * 
 * @link http://schema.org/Artery
 * 
 * @ORM\Entity
 */
class Artery extends Vessel
{
    /**
     * Arterial Branch
     * 
     * @var AnatomicalStructure $arterialBranch The branches that comprise the arterial structure.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arterialBranch;
    /**
     * Source
     * 
     * @var AnatomicalStructure $source The anatomical or organ system that the artery originates from.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;
    /**
     * Supply to
     * 
     * @var AnatomicalStructure $supplyTo The area to which the artery supplies blood to.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplyTo;
}
