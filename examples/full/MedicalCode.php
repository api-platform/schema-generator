<?php

namespace SchemaOrg;

/**
 * Medical Code
 *
 * @link http://schema.org/MedicalCode
 */
class MedicalCode extends MedicalIntangible
{
    /**
     * Code Value
     *
     * @var string The actual code.
     */
    protected $codeValue;
    /**
     * Coding System
     *
     * @var string The coding system, e.g. 'ICD-10'.
     */
    protected $codingSystem;
}
