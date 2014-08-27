<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Enumerations related to health and the practice of medicine.
 * 
 * @see http://schema.org/MedicalEnumeration Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalEnumeration extends MedicalIntangible
{
}
