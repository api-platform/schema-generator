<?php

namespace SchemaOrg;

/**
 * Medical Study
 *
 * @link http://schema.org/MedicalStudy
 */
class MedicalStudy extends MedicalEntity
{
    /**
     * Outcome
     *
     * @var string Expected or actual outcomes of the study.
     */
    protected $outcome;
    /**
     * Population
     *
     * @var string Any characteristics of the population used in the study, e.g. 'males under 65'.
     */
    protected $population;
    /**
     * Sponsor
     *
     * @var Organization Sponsor of the study.
     */
    protected $sponsor;
    /**
     * Status
     *
     * @var MedicalStudyStatus The status of the study (enumerated).
     */
    protected $status;
    /**
     * Study Location
     *
     * @var AdministrativeArea The location in which the study is taking/took place.
     */
    protected $studyLocation;
    /**
     * Study Subject
     *
     * @var MedicalEntity A subject of the study, i.e. one of the medical conditions, therapies, devices, drugs, etc. investigated by the study.
     */
    protected $studySubject;
}
