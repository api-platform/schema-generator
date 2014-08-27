<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An indication for treating an underlying condition, symptom, etc.
 * 
 * @see http://schema.org/TreatmentIndication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TreatmentIndication extends MedicalIndication
{
}
