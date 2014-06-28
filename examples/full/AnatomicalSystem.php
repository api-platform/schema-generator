<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Anatomical System
 * 
 * @link http://schema.org/AnatomicalSystem
 * 
 * @ORM\Entity
 */
class AnatomicalSystem extends MedicalEntity
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
     * Comprised of
     * 
     * @var AnatomicalStructure $comprisedOf The underlying anatomical structures, such as organs, that comprise the anatomical system.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comprisedOf;
    /**
     * Related Condition
     * 
     * @var MedicalCondition $relatedCondition A medical condition associated with this anatomy.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $relatedCondition;
    /**
     * Related Structure
     * 
     * @var AnatomicalStructure $relatedStructure Related anatomical structure(s) that are not part of the system but relate or connect to it, such as vascular bundles associated with an organ system.
     * 
     */
    private $relatedStructure;
    /**
     * Related Therapy
     * 
     * @var MedicalTherapy $relatedTherapy A medical therapy related to this anatomy.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $relatedTherapy;
}
