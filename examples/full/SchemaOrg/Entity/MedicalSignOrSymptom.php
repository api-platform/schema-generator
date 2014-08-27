<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any indication of the existence of a medical condition or disease.
 * 
 * @see http://schema.org/MedicalSignOrSymptom Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalSignOrSymptom extends MedicalEntity
{
    /**
     * @type MedicalCause $cause An underlying cause. More specifically, one of the causative agent(s) that are most directly responsible for the pathophysiologic process that eventually results in the occurrence.
     * @ORM\ManyToOne(targetEntity="MedicalCause")
     */
    private $cause;
    /**
     * @type MedicalTherapy $possibleTreatment A possible treatment to address this condition, sign or symptom.
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $possibleTreatment;
}
