<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Trial
 * 
 * @link http://schema.org/MedicalTrial
 * 
 * @ORM\Entity
 */
class MedicalTrial extends MedicalStudy
{
    /**
     * Phase
     * 
     * @var string $phase The phase of the trial.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $phase;
    /**
     * Trial Design
     * 
     * @var MedicalTrialDesign $trialDesign Specifics about the trial design (enumerated).
     * 
     */
    private $trialDesign;
}
