<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dose Schedule
 * 
 * @link http://schema.org/DoseSchedule
 * 
 * @ORM\MappedSuperclass
 */
class DoseSchedule extends MedicalIntangible
{
    /**
     * Dose Unit
     * 
     * @var string $doseUnit The unit of the dose, e.g. 'mg'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $doseUnit;
    /**
     * Dose Value
     * 
     * @var float $doseValue The value of the dose, e.g. 500.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $doseValue;
    /**
     * Frequency
     * 
     * @var string $frequency How often the dose is taken, e.g. 'daily'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $frequency;
    /**
     * Target Population
     * 
     * @var string $targetPopulation Characteristics of the population for which this is intended, or which typically uses it, e.g. 'adults'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetPopulation;
}
