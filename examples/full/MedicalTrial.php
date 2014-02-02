<?php

namespace SchemaOrg;

/**
 * Medical Trial
 *
 * @link http://schema.org/MedicalTrial
 */
class MedicalTrial extends MedicalStudy
{
    /**
     * Phase
     *
     * @var string The phase of the trial.
     */
    protected $phase;
    /**
     * Trial Design
     *
     * @var MedicalTrialDesign Specifics about the trial design (enumerated).
     */
    protected $trialDesign;
}
