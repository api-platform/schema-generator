<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any medical test, typically performed for diagnostic purposes.
 * 
 * @see http://schema.org/MedicalTest Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalTest extends MedicalEntity
{
    /**
     * @type Drug $affectedBy Drugs that affect the test's results.
     */
    private $affectedBy;
    /**
     * @type string $normalRange Range of acceptable values for a typical patient, when applicable.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $normalRange;
    /**
     * @type MedicalSign $signDetected A sign detected by the test.
     * @ORM\ManyToOne(targetEntity="MedicalSign")
     */
    private $signDetected;
    /**
     * @type MedicalCondition $usedToDiagnose A condition the test is used to diagnose.
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $usedToDiagnose;
    /**
     * @type MedicalDevice $usesDevice Device used to perform the test.
     */
    private $usesDevice;
}
