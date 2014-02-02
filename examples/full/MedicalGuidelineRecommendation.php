<?php

namespace SchemaOrg;

/**
 * Medical Guideline Recommendation
 *
 * @link http://schema.org/MedicalGuidelineRecommendation
 */
class MedicalGuidelineRecommendation extends MedicalGuideline
{
    /**
     * Recommendation Strength
     *
     * @var string Strength of the guideline's recommendation (e.g. 'class I').
     */
    protected $recommendationStrength;
}
