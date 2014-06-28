<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Cause
 * 
 * @link http://schema.org/MedicalCause
 * 
 * @ORM\Entity
 */
class MedicalCause extends MedicalEntity
{
    /**
     * Cause of
     * 
     * @var MedicalEntity $causeOf The condition, complication, symptom, sign, etc. caused.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $causeOf;
}
