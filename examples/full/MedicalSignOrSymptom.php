<?php

namespace SchemaOrg;

/**
 * Medical Sign or Symptom
 *
 * @link http://schema.org/MedicalSignOrSymptom
 */
class MedicalSignOrSymptom extends MedicalEntity
{
    /**
     * Cause
     *
     * @var MedicalCause An underlying cause. More specifically, one of the causative agent(s) that are most directly responsible for the pathophysiologic process that eventually results in the occurrence.
     */
    protected $cause;
    /**
     * Possible Treatment
     *
     * @var MedicalTherapy A possible treatment to address this condition, sign or symptom.
     */
    protected $possibleTreatment;
}
