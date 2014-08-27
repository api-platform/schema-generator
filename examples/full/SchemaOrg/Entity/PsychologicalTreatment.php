<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A process of care relying upon counseling, dialogue, communication, verbalization aimed at improving a mental health condition.
 * 
 * @see http://schema.org/PsychologicalTreatment Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PsychologicalTreatment extends MedicalTherapy
{
}
