<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Sign or Symptom
 * 
 * @link http://schema.org/MedicalSignOrSymptom
 * 
 * @ORM\MappedSuperclass
 */
class MedicalSignOrSymptom extends MedicalEntity
{
    /**
     * Cause
     * 
     * @var MedicalCause $cause An underlying cause. More specifically, one of the causative agent(s) that are most directly responsible for the pathophysiologic process that eventually results in the occurrence.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalCause")
     */
    private $cause;
    /**
     * Possible Treatment
     * 
     * @var MedicalTherapy $possibleTreatment A possible treatment to address this condition, sign or symptom.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $possibleTreatment;
}
