<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The status of a medical study. Enumerated type.
 * 
 * @see http://schema.org/MedicalStudyStatus Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalStudyStatus extends MedicalEnumeration
{
}
