<?php

namespace SchemaOrg;

/**
 * Drug Legal Status
 *
 * @link http://schema.org/DrugLegalStatus
 */
class DrugLegalStatus extends MedicalIntangible
{
    /**
     * Applicable Location
     *
     * @var AdministrativeArea The location in which the status applies.
     */
    protected $applicableLocation;
}
