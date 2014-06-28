<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Quantitative Value
 * 
 * @link http://schema.org/QuantitativeValue
 * 
 * @ORM\Entity
 */
class QuantitativeValue extends StructuredValue
{
    /**
     * Max Value
     * 
     * @var float $maxValue The upper of the product characteristic.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $maxValue;
    /**
     * Min Value
     * 
     * @var float $minValue The lower value of the product characteristic.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $minValue;
    /**
     * Unit Code
     * 
     * @var string $unitCode The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $unitCode;
    /**
     * Value
     * 
     * @var float $value The value of the product characteristic.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $value;
    /**
     * Value Reference
     * 
     * @var Enumeration $valueReference A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     * 
     * @ORM\ManyToOne(targetEntity="Enumeration")
     */
    private $valueReference;
}
