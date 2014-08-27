<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Anatomical features that can be observed by sight (without dissection), including the form and proportions of the human body as well as surface landmarks that correspond to deeper subcutaneous structures. Superficial anatomy plays an important role in sports medicine, phlebotomy, and other medical specialties as underlying anatomical structures can be identified through surface palpation. For example, during back surgery, superficial anatomy can be used to palpate and count vertebrae to find the site of incision. Or in phlebotomy, superficial anatomy can be used to locate an underlying vein; for example, the median cubital vein can be located by palpating the borders of the cubital fossa (such as the epicondyles of the humerus) and then looking for the superficial signs of the vein, such as size, prominence, ability to refill after depression, and feel of surrounding tissue support. As another example, in a subluxation (dislocation) of the glenohumeral joint, the bony structure becomes pronounced with the deltoid muscle failing to cover the glenohumeral joint allowing the edges of the scapula to be superficially visible. Here, the superficial anatomy is the visible edges of the scapula, implying the underlying dislocation of the joint (the related anatomical structure).
 * 
 * @see http://schema.org/SuperficialAnatomy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SuperficialAnatomy extends MedicalEntity
{
    /**
     * @type string $associatedPathophysiology If applicable, a description of the pathophysiology associated with the anatomical system, including potential abnormal changes in the mechanical, physical, and biochemical functions of the system.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $associatedPathophysiology;
    /**
     * @type AnatomicalStructure $relatedAnatomy Anatomical systems or structures that relate to the superficial anatomy.
     */
    private $relatedAnatomy;
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
     * @type string $significance The significance associated with the superficial anatomy; as an example, how characteristics of the superficial anatomy can suggest underlying medical conditions or courses of treatment.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $significance;
}
