<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Device Purpose
 * 
 * @link http://schema.org/MedicalDevicePurpose
 * 
 * @ORM\Entity
 */
class MedicalDevicePurpose extends MedicalEnumeration
{
}
