<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An indication for preventing an underlying condition, symptom, etc.
 * 
 * @see http://schema.org/PreventionIndication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PreventionIndication extends MedicalIndication
{
}
