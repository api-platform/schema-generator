<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any physical manifestation of a person's medical condition discoverable by objective diagnostic tests or physical examination.
 * 
 * @see http://schema.org/MedicalSign Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalSign extends MedicalSignOrSymptom
{
    /**
     * @type PhysicalExam $identifyingExam A physical examination that can identify this sign.
     * @ORM\ManyToOne(targetEntity="PhysicalExam")
     */
    private $identifyingExam;
    /**
     * @type MedicalTest $identifyingTest A diagnostic test that can identify this sign.
     * @ORM\ManyToOne(targetEntity="MedicalTest")
     */
    private $identifyingTest;
}
