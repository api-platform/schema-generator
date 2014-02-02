<?php

namespace SchemaOrg;

/**
 * Medical Guideline
 *
 * @link http://schema.org/MedicalGuideline
 */
class MedicalGuideline extends MedicalEntity
{
    /**
     * Evidence Level
     *
     * @var MedicalEvidenceLevel Strength of evidence of the data used to formulate the guideline (enumerated).
     */
    protected $evidenceLevel;
    /**
     * Evidence Origin
     *
     * @var string Source of the data used to formulate the guidance, e.g. RCT, consensus opinion, etc.
     */
    protected $evidenceOrigin;
    /**
     * Guideline Date
     *
     * @var \DateTime Date on which this guideline's recommendation was made.
     */
    protected $guidelineDate;
    /**
     * Guideline Subject
     *
     * @var MedicalEntity The medical conditions, treatments, etc. that are the subject of the guideline.
     */
    protected $guidelineSubject;
}
