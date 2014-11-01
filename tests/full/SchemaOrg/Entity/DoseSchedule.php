<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A specific dosing schedule for a drug or supplement.
 * 
 * @see http://schema.org/DoseSchedule Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DoseSchedule extends MedicalIntangible
{
    /**
     */
    private $doseUnit;
    /**
     */
    private $doseValue;
    /**
     */
    private $frequency;
    /**
     */
    private $targetPopulation;
}
