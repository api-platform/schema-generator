<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An anatomical system is a group of anatomical structures that work together to perform a certain task. Anatomical systems, such as organ systems, are one organizing principle of anatomy, and can includes circulatory, digestive, endocrine, integumentary, immune, lymphatic, muscular, nervous, reproductive, respiratory, skeletal, urinary, vestibular, and other systems.
 * 
 * @see http://schema.org/AnatomicalSystem Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AnatomicalSystem extends MedicalEntity
{
    /**
     * @type string $associatedPathophysiology If applicable, a description of the pathophysiology associated with the anatomical system, including potential abnormal changes in the mechanical, physical, and biochemical functions of the system.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $associatedPathophysiology;
    /**
     * @type AnatomicalStructure $comprisedOf The underlying anatomical structures, such as organs, that comprise the anatomical system.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comprisedOf;
    /**
     * @type MedicalCondition $relatedCondition A medical condition associated with this anatomy.
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $relatedCondition;
    /**
     * @type AnatomicalStructure $relatedStructure Related anatomical structure(s) that are not part of the system but relate or connect to it, such as vascular bundles associated with an organ system.
     */
    private $relatedStructure;
    /**
     * @type MedicalTherapy $relatedTherapy A medical therapy related to this anatomy.
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $relatedTherapy;
}
