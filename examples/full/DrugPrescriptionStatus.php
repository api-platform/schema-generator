<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug Prescription Status
 * 
 * @link http://schema.org/DrugPrescriptionStatus
 * 
 * @ORM\Entity
 */
class DrugPrescriptionStatus extends MedicalEnumeration
{
}
