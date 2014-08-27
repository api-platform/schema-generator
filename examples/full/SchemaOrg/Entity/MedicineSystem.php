<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Systems of medical practice.
 * 
 * @see http://schema.org/MedicineSystem Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicineSystem extends MedicalEnumeration
{
}
