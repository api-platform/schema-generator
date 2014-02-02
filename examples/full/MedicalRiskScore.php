<?php

namespace SchemaOrg;

/**
 * Medical Risk Score
 *
 * @link http://schema.org/MedicalRiskScore
 */
class MedicalRiskScore extends MedicalRiskEstimator
{
    /**
     * Algorithm
     *
     * @var string The algorithm or rules to follow to compute the score.
     */
    protected $algorithm;
}
