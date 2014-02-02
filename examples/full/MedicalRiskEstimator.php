<?php

namespace SchemaOrg;

/**
 * Medical Risk Estimator
 *
 * @link http://schema.org/MedicalRiskEstimator
 */
class MedicalRiskEstimator extends MedicalEntity
{
    /**
     * Estimates Risk of
     *
     * @var MedicalEntity The condition, complication, or symptom whose risk is being estimated.
     */
    protected $estimatesRiskOf;
    /**
     * Included Risk Factor
     *
     * @var MedicalRiskFactor A modifiable or non-modifiable risk factor included in the calculation, e.g. age, coexisting condition.
     */
    protected $includedRiskFactor;
}
