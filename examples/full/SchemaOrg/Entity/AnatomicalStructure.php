<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any part of the human body, typically a component of an anatomical system. Organs, tissues, and cells are all anatomical structures.
 * 
 * @see http://schema.org/AnatomicalStructure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AnatomicalStructure extends MedicalEntity
{
    /**
     * @type string $associatedPathophysiology If applicable, a description of the pathophysiology associated with the anatomical system, including potential abnormal changes in the mechanical, physical, and biochemical functions of the system.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $associatedPathophysiology;
    /**
     * @type string $bodyLocation Location in the body of the anatomical structure.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $bodyLocation;
    /**
     * @type AnatomicalStructure $connectedTo Other anatomical structures to which this structure is connected.
     */
    private $connectedTo;
    /**
     * @type ImageObject $diagram An image containing a diagram that illustrates the structure and/or its component substructures and/or connections with other structures.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $diagram;
    /**
     * @type string $function Function of the anatomical structure.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $function;
    /**
     * @type AnatomicalSystem $partOfSystem The anatomical or organ system that this structure is part of.
     * @ORM\ManyToOne(targetEntity="AnatomicalSystem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSystem;
    /**
     * @type MedicalCondition $relatedCondition A medical condition associated with this anatomy.
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $relatedCondition;
    /**
     * @type MedicalTherapy $relatedTherapy A medical therapy related to this anatomy.
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $relatedTherapy;
    /**
     * @type AnatomicalStructure $subStructure Component (sub-)structure(s) that comprise this anatomical structure.
     */
    private $subStructure;
}
