<?php

namespace SchemaOrg;

/**
 * Medical Cause
 *
 * @link http://schema.org/MedicalCause
 */
class MedicalCause extends MedicalEntity
{
    /**
     * Cause of
     *
     * @var MedicalEntity The condition, complication, symptom, sign, etc. caused.
     */
    protected $causeOf;
}
