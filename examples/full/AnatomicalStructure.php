<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Anatomical Structure
 * 
 * @link http://schema.org/AnatomicalStructure
 * 
 * @ORM\MappedSuperclass
 */
class AnatomicalStructure extends MedicalEntity
{
    /**
     * Associated Pathophysiology
     * 
     * @var string $associatedPathophysiology If applicable, a description of the pathophysiology associated with the anatomical system, including potential abnormal changes in the mechanical, physical, and biochemical functions of the system.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $associatedPathophysiology;
    /**
     * Body Location
     * 
     * @var string $bodyLocation Location in the body of the anatomical structure.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $bodyLocation;
    /**
     * Connected to
     * 
     * @var AnatomicalStructure $connectedTo Other anatomical structures to which this structure is connected.
     * 
     */
    private $connectedTo;
    /**
     * Diagram
     * 
     * @var ImageObject $diagram An image containing a diagram that illustrates the structure and/or its component substructures and/or connections with other structures.
     * 
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $diagram;
    /**
     * Function
     * 
     * @var string $function Function of the anatomical structure.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $function;
    /**
     * Part of System
     * 
     * @var AnatomicalSystem $partOfSystem The anatomical or organ system that this structure is part of.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalSystem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSystem;
    /**
     * Related Condition
     * 
     * @var MedicalCondition $relatedCondition A medical condition associated with this anatomy.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $relatedCondition;
    /**
     * Related Therapy
     * 
     * @var MedicalTherapy $relatedTherapy A medical therapy related to this anatomy.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $relatedTherapy;
    /**
     * Sub Structure
     * 
     * @var AnatomicalStructure $subStructure Component (sub-)structure(s) that comprise this anatomical structure.
     * 
     */
    private $subStructure;
}
