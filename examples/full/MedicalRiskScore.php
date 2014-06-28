<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Risk Score
 * 
 * @link http://schema.org/MedicalRiskScore
 * 
 * @ORM\Entity
 */
class MedicalRiskScore extends MedicalRiskEstimator
{
    /**
     * Algorithm
     * 
     * @var string $algorithm The algorithm or rules to follow to compute the score.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $algorithm;
}
