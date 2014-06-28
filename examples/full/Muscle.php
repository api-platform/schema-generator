<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Muscle
 * 
 * @link http://schema.org/Muscle
 * 
 * @ORM\Entity
 */
class Muscle extends AnatomicalStructure
{
    /**
     * Action
     * 
     * @var string $action The movement the muscle generates.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $action;
    /**
     * Antagonist
     * 
     * @var Muscle $antagonist The muscle whose action counteracts the specified muscle.
     * 
     * @ORM\ManyToOne(targetEntity="Muscle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $antagonist;
    /**
     * Blood Supply
     * 
     * @var Vessel $bloodSupply The blood vessel that carries blood from the heart to the muscle.
     * 
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloodSupply;
    /**
     * Insertion
     * 
     * @var AnatomicalStructure $insertion The place of attachment of a muscle, or what the muscle moves.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $insertion;
    /**
     * Nerve
     * 
     * @var Nerve $nerve The underlying innervation associated with the muscle.
     * 
     * @ORM\ManyToOne(targetEntity="Nerve")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nerve;
    /**
     * Origin
     * 
     * @var AnatomicalStructure $origin The place or point where a muscle arises.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $origin;
}
