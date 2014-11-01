<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Property value specification.
 * 
 * @see http://schema.org/PropertyValueSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PropertyValueSpecification extends Intangible
{
    /**
     */
    private $maxValue;
    /**
     */
    private $minValue;
    /**
     */
    private $valueName;
    /**
     */
    private $valueRequired;
    /**
     */
    private $defaultValue;
    /**
     */
    private $readonlyValue;
    /**
     */
    private $multipleValues;
    /**
     */
    private $valueMinLength;
    /**
     */
    private $valueMaxLength;
    /**
     */
    private $valuePattern;
    /**
     */
    private $stepValue;
}
