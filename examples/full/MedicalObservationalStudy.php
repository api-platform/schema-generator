<?php

namespace SchemaOrg;

/**
 * Medical Observational Study
 *
 * @link http://schema.org/MedicalObservationalStudy
 */
class MedicalObservationalStudy extends MedicalStudy
{
    /**
     * Study Design
     *
     * @var MedicalObservationalStudyDesign Specifics about the observational study design (enumerated).
     */
    protected $studyDesign;
}
