<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Specialty
 * 
 * @link http://schema.org/MedicalSpecialty
 * 
 * @ORM\Entity
 */
class MedicalSpecialty extends MedicalEnumeration
{
}
