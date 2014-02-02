<?php

namespace SchemaOrg;

/**
 * Hospital
 *
 * @link http://schema.org/Hospital
 */
class Hospital extends CivicStructure
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
     * Medical Specialty
     *
     * @var MedicalSpecialty A medical specialty of the provider.
     */
    protected $medicalSpecialty;
}
