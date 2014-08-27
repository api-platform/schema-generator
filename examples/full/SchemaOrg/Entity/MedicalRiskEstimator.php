<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any rule set or interactive tool for estimating the risk of developing a complication or condition.
 * 
 * @see http://schema.org/MedicalRiskEstimator Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalRiskEstimator extends MedicalEntity
{
    /**
     * @type MedicalEntity $estimatesRiskOf The condition, complication, or symptom whose risk is being estimated.
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $estimatesRiskOf;
    /**
     * @type MedicalRiskFactor $includedRiskFactor A modifiable or non-modifiable risk factor included in the calculation, e.g. age, coexisting condition.
     * @ORM\ManyToOne(targetEntity="MedicalRiskFactor")
     */
    private $includedRiskFactor;
}
