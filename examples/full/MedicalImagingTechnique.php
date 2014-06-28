<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Imaging Technique
 * 
 * @link http://schema.org/MedicalImagingTechnique
 * 
 * @ORM\Entity
 */
class MedicalImagingTechnique extends MedicalEnumeration
{
}
