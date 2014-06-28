<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Symptom
 * 
 * @link http://schema.org/MedicalSymptom
 * 
 * @ORM\Entity
 */
class MedicalSymptom extends MedicalSignOrSymptom
{
}
