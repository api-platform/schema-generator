<?php

namespace SchemaOrg;

/**
 * Dose Schedule
 *
 * @link http://schema.org/DoseSchedule
 */
class DoseSchedule extends MedicalIntangible
{
    /**
     * Dose Unit
     *
     * @var string The unit of the dose, e.g. 'mg'.
     */
    protected $doseUnit;
    /**
     * Dose Value
     *
     * @var float The value of the dose, e.g. 500.
     */
    protected $doseValue;
    /**
     * Frequency
     *
     * @var string How often the dose is taken, e.g. 'daily'.
     */
    protected $frequency;
    /**
     * Target Population
     *
     * @var string Characteristics of the population for which this is intended, or which typically uses it, e.g. 'adults'.
     */
    protected $targetPopulation;
}
