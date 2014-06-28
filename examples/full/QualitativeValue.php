<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Qualitative Value
 * 
 * @link http://schema.org/QualitativeValue
 * 
 * @ORM\Entity
 */
class QualitativeValue extends Enumeration
{
    /**
     * Equal
     * 
     * @var QualitativeValue $equal This ordering relation for qualitative values indicates that the subject is equal to the object.
     * 
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $equal;
    /**
     * Greater
     * 
     * @var QualitativeValue $greater This ordering relation for qualitative values indicates that the subject is greater than the object.
     * 
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $greater;
    /**
     * Greater or Equal
     * 
     * @var QualitativeValue $greaterOrEqual This ordering relation for qualitative values indicates that the subject is greater than or equal to the object.
     * 
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $greaterOrEqual;
    /**
     * Lesser
     * 
     * @var QualitativeValue $lesser This ordering relation for qualitative values indicates that the subject is lesser than the object.
     * 
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $lesser;
    /**
     * Lesser or Equal
     * 
     * @var QualitativeValue $lesserOrEqual This ordering relation for qualitative values indicates that the subject is lesser than or equal to the object.
     * 
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $lesserOrEqual;
    /**
     * Non Equal
     * 
     * @var QualitativeValue $nonEqual This ordering relation for qualitative values indicates that the subject is not equal to the object.
     * 
     * @ORM\ManyToOne(targetEntity="QualitativeValue")
     */
    private $nonEqual;
    /**
     * Value Reference
     * 
     * @var Enumeration $valueReference A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     * 
     * @ORM\ManyToOne(targetEntity="Enumeration")
     */
    private $valueReference;
}
