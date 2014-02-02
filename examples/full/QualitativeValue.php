<?php

namespace SchemaOrg;

/**
 * Qualitative Value
 *
 * @link http://schema.org/QualitativeValue
 */
class QualitativeValue extends Enumeration
{
    /**
     * Equal
     *
     * @var QualitativeValue This ordering relation for qualitative values indicates that the subject is equal to the object.
     */
    protected $equal;
    /**
     * Greater
     *
     * @var QualitativeValue This ordering relation for qualitative values indicates that the subject is greater than the object.
     */
    protected $greater;
    /**
     * Greater or Equal
     *
     * @var QualitativeValue This ordering relation for qualitative values indicates that the subject is greater than or equal to the object.
     */
    protected $greaterOrEqual;
    /**
     * Lesser
     *
     * @var QualitativeValue This ordering relation for qualitative values indicates that the subject is lesser than the object.
     */
    protected $lesser;
    /**
     * Lesser or Equal
     *
     * @var QualitativeValue This ordering relation for qualitative values indicates that the subject is lesser than or equal to the object.
     */
    protected $lesserOrEqual;
    /**
     * Non Equal
     *
     * @var QualitativeValue This ordering relation for qualitative values indicates that the subject is not equal to the object.
     */
    protected $nonEqual;
    /**
     * Value Reference (Enumeration)
     *
     * @var Enumeration A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     */
    protected $valueReferenceEnumeration;
    /**
     * Value Reference (StructuredValue)
     *
     * @var StructuredValue A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.
     */
    protected $valueReferenceStructuredValue;
}
