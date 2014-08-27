<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categories of medical devices, organized by the purpose or intended use of the device.
 * 
 * @see http://schema.org/MedicalDevicePurpose Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalDevicePurpose extends MedicalEnumeration
{
}
