<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Psychological Treatment
 * 
 * @link http://schema.org/PsychologicalTreatment
 * 
 * @ORM\Entity
 */
class PsychologicalTreatment extends MedicalTherapy
{
}
