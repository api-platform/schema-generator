<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Test
 * 
 * @link http://schema.org/MedicalTest
 * 
 * @ORM\MappedSuperclass
 */
class MedicalTest extends MedicalEntity
{
    /**
     * Affected by
     * 
     * @var Drug $affectedBy Drugs that affect the test's results.
     * 
     */
    private $affectedBy;
    /**
     * Normal Range
     * 
     * @var string $normalRange Range of acceptable values for a typical patient, when applicable.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $normalRange;
    /**
     * Sign Detected
     * 
     * @var MedicalSign $signDetected A sign detected by the test.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalSign")
     */
    private $signDetected;
    /**
     * Used to Diagnose
     * 
     * @var MedicalCondition $usedToDiagnose A condition the test is used to diagnose.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $usedToDiagnose;
    /**
     * Uses Device
     * 
     * @var MedicalDevice $usesDevice Device used to perform the test.
     * 
     */
    private $usesDevice;
}
