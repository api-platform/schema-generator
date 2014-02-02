<?php

namespace SchemaOrg;

/**
 * Medical Condition
 *
 * @link http://schema.org/MedicalCondition
 */
class MedicalCondition extends MedicalEntity
{
    /**
     * Associated Anatomy (AnatomicalSystem)
     *
     * @var AnatomicalSystem The anatomy of the underlying organ system or structures associated with this entity.
     */
    protected $associatedAnatomyAnatomicalSystem;
    /**
     * Associated Anatomy (SuperficialAnatomy)
     *
     * @var SuperficialAnatomy The anatomy of the underlying organ system or structures associated with this entity.
     */
    protected $associatedAnatomySuperficialAnatomy;
    /**
     * Associated Anatomy (AnatomicalStructure)
     *
     * @var AnatomicalStructure The anatomy of the underlying organ system or structures associated with this entity.
     */
    protected $associatedAnatomyAnatomicalStructure;
    /**
     * Cause
     *
     * @var MedicalCause An underlying cause. More specifically, one of the causative agent(s) that are most directly responsible for the pathophysiologic process that eventually results in the occurrence.
     */
    protected $cause;
    /**
     * Differential Diagnosis
     *
     * @var DDxElement One of a set of differential diagnoses for the condition. Specifically, a closely-related or competing diagnosis typically considered later in the cognitive process whereby this medical condition is distinguished from others most likely responsible for a similar collection of signs and symptoms to reach the most parsimonious diagnosis or diagnoses in a patient.
     */
    protected $differentialDiagnosis;
    /**
     * Epidemiology
     *
     * @var string The characteristics of associated patients, such as age, gender, race etc.
     */
    protected $epidemiology;
    /**
     * Expected Prognosis
     *
     * @var string The likely outcome in either the short term or long term of the medical condition.
     */
    protected $expectedPrognosis;
    /**
     * Natural Progression
     *
     * @var string The expected progression of the condition if it is not treated and allowed to progress naturally.
     */
    protected $naturalProgression;
    /**
     * Pathophysiology
     *
     * @var string Changes in the normal mechanical, physical, and biochemical functions that are associated with this activity or condition.
     */
    protected $pathophysiology;
    /**
     * Possible Complication
     *
     * @var string A possible unexpected and unfavorable evolution of a medical condition. Complications may include worsening of the signs or symptoms of the disease, extension of the condition to other organ systems, etc.
     */
    protected $possibleComplication;
    /**
     * Possible Treatment
     *
     * @var MedicalTherapy A possible treatment to address this condition, sign or symptom.
     */
    protected $possibleTreatment;
    /**
     * Primary Prevention
     *
     * @var MedicalTherapy A preventative therapy used to prevent an initial occurrence of the medical condition, such as vaccination.
     */
    protected $primaryPrevention;
    /**
     * Risk Factor
     *
     * @var MedicalRiskFactor A modifiable or non-modifiable factor that increases the risk of a patient contracting this condition, e.g. age,  coexisting condition.
     */
    protected $riskFactor;
    /**
     * Secondary Prevention
     *
     * @var MedicalTherapy A preventative therapy used to prevent reoccurrence of the medical condition after an initial episode of the condition.
     */
    protected $secondaryPrevention;
    /**
     * Sign or Symptom
     *
     * @var MedicalSignOrSymptom A sign or symptom of this condition. Signs are objective or physically observable manifestations of the medical condition while symptoms are the subjective experienceof the medical condition.
     */
    protected $signOrSymptom;
    /**
     * Stage
     *
     * @var MedicalConditionStage The stage of the condition, if applicable.
     */
    protected $stage;
    /**
     * Subtype
     *
     * @var string A more specific type of the condition, where applicable, for example 'Type 1 Diabetes', 'Type 2 Diabetes', or 'Gestational Diabetes' for Diabetes.
     */
    protected $subtype;
    /**
     * Typical Test
     *
     * @var MedicalTest A medical test typically performed given this condition.
     */
    protected $typicalTest;
}
