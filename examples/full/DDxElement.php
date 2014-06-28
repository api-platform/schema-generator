<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * D Dx Element
 * 
 * @link http://schema.org/DDxElement
 * 
 * @ORM\Entity
 */
class DDxElement extends MedicalIntangible
{
    /**
     * Diagnosis
     * 
     * @var MedicalCondition $diagnosis One or more alternative conditions considered in the differential diagnosis process.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalCondition")
     */
    private $diagnosis;
    /**
     * Distinguishing Sign
     * 
     * @var MedicalSignOrSymptom $distinguishingSign One of a set of signs and symptoms that can be used to distinguish this diagnosis from others in the differential diagnosis.
     * 
     */
    private $distinguishingSign;
}
