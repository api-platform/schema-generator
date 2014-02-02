<?php

namespace SchemaOrg;

/**
 * Physician
 *
 * @link http://schema.org/Physician
 */
class Physician extends MedicalOrganization
{
    /**
     * Available Service (MedicalTest)
     *
     * @var MedicalTest A medical service available from this provider.
     */
    protected $availableServiceMedicalTest;
    /**
     * Available Service (MedicalProcedure)
     *
     * @var MedicalProcedure A medical service available from this provider.
     */
    protected $availableServiceMedicalProcedure;
    /**
     * Available Service (MedicalTherapy)
     *
     * @var MedicalTherapy A medical service available from this provider.
     */
    protected $availableServiceMedicalTherapy;
    /**
     * Hospital Affiliation
     *
     * @var Hospital A hospital with which the physician or office is affiliated.
     */
    protected $hospitalAffiliation;
    /**
     * Medical Specialty
     *
     * @var MedicalSpecialty A medical specialty of the provider.
     */
    protected $medicalSpecialty;
}
