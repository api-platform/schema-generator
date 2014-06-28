<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Risk Calculator
 * 
 * @link http://schema.org/MedicalRiskCalculator
 * 
 * @ORM\Entity
 */
class MedicalRiskCalculator extends MedicalRiskEstimator
{
}
