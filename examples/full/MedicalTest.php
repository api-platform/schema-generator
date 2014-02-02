<?php

namespace SchemaOrg;

/**
 * Medical Test
 *
 * @link http://schema.org/MedicalTest
 */
class MedicalTest extends MedicalEntity
{
    /**
     * Affected by
     *
     * @var Drug Drugs that affect the test's results.
     */
    protected $affectedBy;
    /**
     * Normal Range
     *
     * @var string Range of acceptable values for a typical patient, when applicable.
     */
    protected $normalRange;
    /**
     * Sign Detected
     *
     * @var MedicalSign A sign detected by the test.
     */
    protected $signDetected;
    /**
     * Used to Diagnose
     *
     * @var MedicalCondition A condition the test is used to diagnose.
     */
    protected $usedToDiagnose;
    /**
     * Uses Device
     *
     * @var MedicalDevice Device used to perform the test.
     */
    protected $usesDevice;
}
