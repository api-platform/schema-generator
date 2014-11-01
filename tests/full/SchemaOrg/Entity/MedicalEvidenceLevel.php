<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Level of evidence for a medical guideline. Enumerated type.
 * 
 * @see http://schema.org/MedicalEvidenceLevel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalEvidenceLevel extends MedicalEnumeration
{
}
