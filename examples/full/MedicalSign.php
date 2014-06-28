<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Sign
 * 
 * @link http://schema.org/MedicalSign
 * 
 * @ORM\Entity
 */
class MedicalSign extends MedicalSignOrSymptom
{
    /**
     * Identifying Exam
     * 
     * @var PhysicalExam $identifyingExam A physical examination that can identify this sign.
     * 
     * @ORM\ManyToOne(targetEntity="PhysicalExam")
     */
    private $identifyingExam;
    /**
     * Identifying Test
     * 
     * @var MedicalTest $identifyingTest A diagnostic test that can identify this sign.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTest")
     */
    private $identifyingTest;
}
