<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Indicates whether this drug is available by prescription or over-the-counter.
 * 
 * @see http://schema.org/DrugPrescriptionStatus Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrugPrescriptionStatus extends MedicalEnumeration
{
}
