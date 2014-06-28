<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Physical Activity Category
 * 
 * @link http://schema.org/PhysicalActivityCategory
 * 
 * @ORM\Entity
 */
class PhysicalActivityCategory extends MedicalEnumeration
{
}
