<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A muscle is an anatomical structure consisting of a contractile form of tissue that animals use to effect movement.
 * 
 * @see http://schema.org/Muscle Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Muscle extends AnatomicalStructure
{
    /**
     * @type string $action The movement the muscle generates.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $action;
    /**
     * @type string $muscleAction The movement the muscle generates.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $muscleAction;
    /**
     * @type Muscle $antagonist The muscle whose action counteracts the specified muscle.
     * @ORM\ManyToOne(targetEntity="Muscle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $antagonist;
    /**
     * @type Vessel $bloodSupply The blood vessel that carries blood from the heart to the muscle.
     * @ORM\ManyToOne(targetEntity="Vessel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloodSupply;
    /**
     * @type AnatomicalStructure $insertion The place of attachment of a muscle, or what the muscle moves.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $insertion;
    /**
     * @type Nerve $nerve The underlying innervation associated with the muscle.
     * @ORM\ManyToOne(targetEntity="Nerve")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nerve;
    /**
     * @type AnatomicalStructure $origin The place or point where a muscle arises.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $origin;
}
