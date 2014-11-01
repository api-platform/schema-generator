<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Design models for medical trials. Enumerated type.
 * 
 * @see http://schema.org/MedicalTrialDesign Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalTrialDesign extends MedicalEnumeration
{
}
