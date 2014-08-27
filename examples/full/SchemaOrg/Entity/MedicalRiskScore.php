<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A simple system that adds up the number of risk factors to yield a score that is associated with prognosis, e.g. CHAD score, TIMI risk score.
 * 
 * @see http://schema.org/MedicalRiskScore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalRiskScore extends MedicalRiskEstimator
{
    /**
     * @type string $algorithm The algorithm or rules to follow to compute the score.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $algorithm;
}
