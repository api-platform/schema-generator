<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A type of physical examination of a patient performed by a physician. Enumerated type.
 * 
 * @see http://schema.org/PhysicalExam Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PhysicalExam extends MedicalEnumeration
{
}
