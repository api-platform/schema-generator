<?php

namespace SchemaOrg;

/**
 * D Dx Element
 *
 * @link http://schema.org/DDxElement
 */
class DDxElement extends MedicalIntangible
{
    /**
     * Diagnosis
     *
     * @var MedicalCondition One or more alternative conditions considered in the differential diagnosis process.
     */
    protected $diagnosis;
    /**
     * Distinguishing Sign
     *
     * @var MedicalSignOrSymptom One of a set of signs and symptoms that can be used to distinguish this diagnosis from others in the differential diagnosis.
     */
    protected $distinguishingSign;
}
