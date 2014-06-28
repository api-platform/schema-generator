<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Risk Factor
 * 
 * @link http://schema.org/MedicalRiskFactor
 * 
 * @ORM\Entity
 */
class MedicalRiskFactor extends MedicalEntity
{
    /**
     * Increases Risk of
     * 
     * @var MedicalEntity $increasesRiskOf The condition, complication, etc. influenced by this factor.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $increasesRiskOf;
}
