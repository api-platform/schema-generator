<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categories of physical activity, organized by physiologic classification.
 * 
 * @see http://schema.org/PhysicalActivityCategory Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PhysicalActivityCategory extends MedicalEnumeration
{
}
