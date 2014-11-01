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
     */
    private $cause;
    /**
     */
    private $possibleTreatment;
}
