<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A guideline contraindication that designates a process as harmful and where quality of the data supporting the contraindication is sound.
 * 
 * @see http://schema.org/MedicalGuidelineContraindication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalGuidelineContraindication extends MedicalGuideline
{
}
