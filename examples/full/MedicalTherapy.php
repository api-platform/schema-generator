<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Therapy
 * 
 * @link http://schema.org/MedicalTherapy
 * 
 * @ORM\MappedSuperclass
 */
class MedicalTherapy extends MedicalEntity
{
    /**
     * Adverse Outcome
     * 
     * @var MedicalEntity $adverseOutcome A possible complication and/or side effect of this therapy. If it is known that an adverse outcome is serious (resulting in death, disability, or permanent damage; requiring hospitalization; or is otherwise life-threatening or requires immediate medical attention), tag it as a seriouseAdverseOutcome instead.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     */
    private $adverseOutcome;
    /**
     * Contraindication
     * 
     * @var MedicalContraindication $contraindication A contraindication for this therapy.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalContraindication")
     */
    private $contraindication;
    /**
     * Duplicate Therapy
     * 
     * @var MedicalTherapy $duplicateTherapy A therapy that duplicates or overlaps this one.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $duplicateTherapy;
    /**
     * Indication
     * 
     * @var MedicalIndication $indication A factor that indicates use of this therapy for treatment and/or prevention of a condition, symptom, etc. For therapies such as drugs, indications can include both officially-approved indications as well as off-label uses. These can be distinguished by using the ApprovedIndication subtype of MedicalIndication.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalIndication")
     */
    private $indication;
    /**
     * Serious Adverse Outcome
     * 
     * @var MedicalEntity $seriousAdverseOutcome A possible serious complication and/or serious side effect of this therapy. Serious adverse outcomes include those that are life-threatening; result in death, disability, or permanent damage; require hospitalization or prolong existing hospitalization; cause congenital anomalies or birth defects; or jeopardize the patient and may require medical or surgical intervention to prevent one of the outcomes in this definition.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     */
    private $seriousAdverseOutcome;
}
