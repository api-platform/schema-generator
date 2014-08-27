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
     * @type string $valueName Indicates the name of the PropertyValueSpecification to be used in URL templates and form encoding in a manner analogous to HTML's input@name.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $valueName;
    /**
     * @type boolean $valueRequired Whether the property must be filled in to complete the action.  Default is false.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $valueRequired;
    /**
     * @type Thing $defaultValue The default value of the input.  For properties that expect a literal, the default is a literal value, for properties that expect an object, it's an ID reference to one of the current values.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $defaultValue;
    /**
     * @type boolean $readonlyValue Whether or not a property is mutable.  Default is false. Specifying this for a property that also has a value makes it act similar to a "hidden" input in an HTML form.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $readonlyValue;
    /**
     * @type boolean $multipleValues Whether multiple values are allowed for the property.  Default is false.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $multipleValues;
    /**
     * @type float $valueMinLength Specifies the minimum allowed range for number of characters in a literal value.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $valueMinLength;
    /**
     * @type float $valueMaxLength Specifies the allowed range for number of characters in a literal value.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $valueMaxLength;
    /**
     * @type float $valuePattern Specifies a regular expression for testing literal values according to the HTML spec.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $valuePattern;
    /**
     * @type float $stepValue The stepValue attribute indicates the granularity that is expected (and required) of the value in a PropertyValueSpecification.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $stepValue;
}
