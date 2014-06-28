<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Guideline Contraindication
 * 
 * @link http://schema.org/MedicalGuidelineContraindication
 * 
 * @ORM\Entity
 */
class MedicalGuidelineContraindication extends MedicalGuideline
{
}
