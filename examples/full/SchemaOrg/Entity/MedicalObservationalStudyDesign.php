<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Design models for observational medical studies. Enumerated type.
 * 
 * @see http://schema.org/MedicalObservationalStudyDesign Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalObservationalStudyDesign extends MedicalEnumeration
{
}
