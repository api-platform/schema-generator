<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any object used in a medical capacity, such as to diagnose or treat a patient.
 * 
 * @see http://schema.org/MedicalDevice Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalDevice extends MedicalEntity
{
    /**
     * @type MedicalEntity $adverseOutcome A possible complication and/or side effect of this therapy. If it is known that an adverse outcome is serious (resulting in death, disability, or permanent damage; requiring hospitalization; or is otherwise life-threatening or requires immediate medical attention), tag it as a seriouseAdverseOutcome instead.
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     */
    private $adverseOutcome;
    /**
     * @type MedicalContraindication $contraindication A contraindication for this therapy.
     * @ORM\ManyToOne(targetEntity="MedicalContraindication")
     */
    private $contraindication;
    /**
     * @type MedicalIndication $indication A factor that indicates use of this therapy for treatment and/or prevention of a condition, symptom, etc. For therapies such as drugs, indications can include both officially-approved indications as well as off-label uses. These can be distinguished by using the ApprovedIndication subtype of MedicalIndication.
     * @ORM\ManyToOne(targetEntity="MedicalIndication")
     */
    private $indication;
    /**
     * @type string $postOp A description of the postoperative procedures, care, and/or followups for this device.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $postOp;
    /**
     * @type string $preOp A description of the workup, testing, and other preparations required before implanting this device.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $preOp;
    /**
     * @type string $procedure A description of the procedure involved in setting up, using, and/or installing the device.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $procedure;
    /**
     * @type MedicalDevicePurpose $purpose A goal towards an action is taken. Can be concrete or abstract.
     * @ORM\ManyToOne(targetEntity="MedicalDevicePurpose")
     */
    private $purpose;
    /**
     * @type MedicalEntity $seriousAdverseOutcome A possible serious complication and/or serious side effect of this therapy. Serious adverse outcomes include those that are life-threatening; result in death, disability, or permanent damage; require hospitalization or prolong existing hospitalization; cause congenital anomalies or birth defects; or jeopardize the patient and may require medical or surgical intervention to prevent one of the outcomes in this definition.
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     */
    private $seriousAdverseOutcome;
}
