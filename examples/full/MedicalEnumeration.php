<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Enumeration
 * 
 * @link http://schema.org/MedicalEnumeration
 * 
 * @ORM\MappedSuperclass
 */
class MedicalEnumeration extends MedicalIntangible
{
}
