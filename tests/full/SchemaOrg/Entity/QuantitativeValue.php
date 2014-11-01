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
     */
    private $maxValue;
    /**
     */
    private $minValue;
    /**
     */
    private $unitCode;
    /**
     */
    private $value;
    /**
     */
    private $valueReference;
}
