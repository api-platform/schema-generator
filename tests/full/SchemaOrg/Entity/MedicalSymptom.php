<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any indication of the existence of a medical condition or disease that is apparent to the patient.
 * 
 * @see http://schema.org/MedicalSymptom Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalSymptom extends MedicalSignOrSymptom
{
}
