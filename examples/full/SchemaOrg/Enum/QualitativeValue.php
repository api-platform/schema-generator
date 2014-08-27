<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * A predefined value for a product characteristic, e.g. the the power cord plug type "US" or the garment sizes "S", "M", "L", and "XL"
 * 
 * @see http://schema.org/QualitativeValue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class QualitativeValue extends Enum
{
    /**
     * @type QualitativeValue $equal This ordering relation for qualitative values indicates that the subject is equal to the object.
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $equal;
    /**
     * @type QualitativeValue $greater This ordering relation for qualitative values indicates that the subject is greater than the object.
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $greater;
    /**
     * @type QualitativeValue $greaterOrEqual This ordering relation for qualitative values indicates that the subject is greater than or equal to the object.
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $greaterOrEqual;
    /**
     * @type QualitativeValue $lesser This ordering relation for qualitative values indicates that the subject is lesser than the object.
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $lesser;
    /**
     * @type QualitativeValue $lesserOrEqual This ordering relation for qualitative values indicates that the subject is lesser than or equal to the object.
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $lesserOrEqual;
    /**
     * @type QualitativeValue $nonEqual This ordering relation for qualitative values indicates that the subject is not equal to the object.
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $nonEqual;
    /**
     * @type Enumeration $valueReference A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     * @ORM\ManyToOne(targetEntity="Enumeration")
     */
    private $valueReference;
}
