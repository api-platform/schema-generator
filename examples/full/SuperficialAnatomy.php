<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Superficial Anatomy
 * 
 * @link http://schema.org/SuperficialAnatomy
 * 
 * @ORM\Entity
 */
class SuperficialAnatomy extends MedicalEntity
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
     * Related Anatomy
     * 
     * @var AnatomicalStructure $relatedAnatomy Anatomical systems or structures that relate to the superficial anatomy.
     * 
     */
    private $relatedAnatomy;
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
     * Significance
     * 
     * @var string $significance The significance associated with the superficial anatomy; as an example, how characteristics of the superficial anatomy can suggest underlying medical conditions or courses of treatment.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $significance;
}
