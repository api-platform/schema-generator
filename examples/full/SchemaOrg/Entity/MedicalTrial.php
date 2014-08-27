<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical trial is a type of medical study that uses scientific process used to compare the safety and efficacy of medical therapies or medical procedures. In general, medical trials are controlled and subjects are allocated at random to the different treatment and/or control groups.
 * 
 * @see http://schema.org/MedicalTrial Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalTrial extends MedicalStudy
{
    /**
     * @type string $phase The phase of the trial.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $phase;
    /**
     * @type MedicalTrialDesign $trialDesign Specifics about the trial design (enumerated).
     */
    private $trialDesign;
}
