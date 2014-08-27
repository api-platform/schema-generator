<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any medical imaging modality typically used for diagnostic purposes. Enumerated type.
 * 
 * @see http://schema.org/MedicalImagingTechnique Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalImagingTechnique extends MedicalEnumeration
{
}
