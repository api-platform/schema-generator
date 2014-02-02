<?php

namespace SchemaOrg;

/**
 * Medical Device
 *
 * @link http://schema.org/MedicalDevice
 */
class MedicalDevice extends MedicalEntity
{
    /**
     * Adverse Outcome
     *
     * @var MedicalEntity A possible complication and/or side effect of this therapy. If it is known that an adverse outcome is serious (resulting in death, disability, or permanent damage; requiring hospitalization; or is otherwise life-threatening or requires immediate medical attention), tag it as a seriouseAdverseOutcome instead.
     */
    protected $adverseOutcome;
    /**
     * Contraindication
     *
     * @var MedicalContraindication A contraindication for this therapy.
     */
    protected $contraindication;
    /**
     * Indication
     *
     * @var MedicalIndication A factor that indicates use of this therapy for treatment and/or prevention of a condition, symptom, etc. For therapies such as drugs, indications can include both officially-approved indications as well as off-label uses. These can be distinguished by using the ApprovedIndication subtype of MedicalIndication.
     */
    protected $indication;
    /**
     * Post Op
     *
     * @var string A description of the postoperative procedures, care, and/or followups for this device.
     */
    protected $postOp;
    /**
     * Pre Op
     *
     * @var string A description of the workup, testing, and other preparations required before implanting this device.
     */
    protected $preOp;
    /**
     * Procedure
     *
     * @var string A description of the procedure involved in setting up, using, and/or installing the device.
     */
    protected $procedure;
    /**
     * Purpose (Thing)
     *
     * @var Thing A goal towards an action is taken. Can be concrete or abstract.
     */
    protected $purposeThing;
    /**
     * Purpose (MedicalDevicePurpose)
     *
     * @var MedicalDevicePurpose A goal towards an action is taken. Can be concrete or abstract.
     */
    protected $purposeMedicalDevicePurpose;
    /**
     * Serious Adverse Outcome
     *
     * @var MedicalEntity A possible serious complication and/or serious side effect of this therapy. Serious adverse outcomes include those that are life-threatening; result in death, disability, or permanent damage; require hospitalization or prolong existing hospitalization; cause congenital anomalies or birth defects; or jeopardize the patient and may require medical or surgical intervention to prevent one of the outcomes in this definition.
     */
    protected $seriousAdverseOutcome;
}
