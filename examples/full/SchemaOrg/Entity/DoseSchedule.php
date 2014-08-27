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
     * @type string $doseUnit The unit of the dose, e.g. 'mg'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $doseUnit;
    /**
     * @type float $doseValue The value of the dose, e.g. 500.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $doseValue;
    /**
     * @type string $frequency How often the dose is taken, e.g. 'daily'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $frequency;
    /**
     * @type string $targetPopulation Characteristics of the population for which this is intended, or which typically uses it, e.g. 'adults'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetPopulation;
}
