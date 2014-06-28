<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Guideline Recommendation
 * 
 * @link http://schema.org/MedicalGuidelineRecommendation
 * 
 * @ORM\Entity
 */
class MedicalGuidelineRecommendation extends MedicalGuideline
{
    /**
     * Recommendation Strength
     * 
     * @var string $recommendationStrength Strength of the guideline's recommendation (e.g. 'class I').
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recommendationStrength;
}
