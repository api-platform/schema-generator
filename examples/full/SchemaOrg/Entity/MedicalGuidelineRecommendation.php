<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A guideline recommendation that is regarded as efficacious and where quality of the data supporting the recommendation is sound.
 * 
 * @see http://schema.org/MedicalGuidelineRecommendation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalGuidelineRecommendation extends MedicalGuideline
{
    /**
     * @type string $recommendationStrength Strength of the guideline's recommendation (e.g. 'class I').
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recommendationStrength;
}
