<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 *  A point value or interval for product characteristics and other purposes.
 * 
 * @see http://schema.org/QuantitativeValue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class QuantitativeValue extends StructuredValue
{
    /**
     * @type float $maxValue The upper value of some characteristic or property.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $maxValue;
    /**
     * @type float $minValue The lower value of some characteristic or property.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $minValue;
    /**
     * @type string $unitCode The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $unitCode;
    /**
     * @type float $value The value of the product characteristic.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $value;
    /**
     * @type Enumeration $valueReference A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     * @ORM\ManyToOne(targetEntity="Enumeration")
     */
    private $valueReference;
}
