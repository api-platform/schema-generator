<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Risk Estimator
 * 
 * @link http://schema.org/MedicalRiskEstimator
 * 
 * @ORM\MappedSuperclass
 */
class MedicalRiskEstimator extends MedicalEntity
{
    /**
     * Estimates Risk of
     * 
     * @var MedicalEntity $estimatesRiskOf The condition, complication, or symptom whose risk is being estimated.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $estimatesRiskOf;
    /**
     * Included Risk Factor
     * 
     * @var MedicalRiskFactor $includedRiskFactor A modifiable or non-modifiable risk factor included in the calculation, e.g. age, coexisting condition.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalRiskFactor")
     */
    private $includedRiskFactor;
}
