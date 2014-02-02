<?php

namespace SchemaOrg;

/**
 * Joint
 *
 * @link http://schema.org/Joint
 */
class Joint extends AnatomicalStructure
{
    /**
     * Biomechnical Class
     *
     * @var string The biomechanical properties of the bone.
     */
    protected $biomechnicalClass;
    /**
     * Functional Class
     *
     * @var string The degree of mobility the joint allows.
     */
    protected $functionalClass;
    /**
     * Structural Class
     *
     * @var string The name given to how bone physically connects to each other.
     */
    protected $structuralClass;
}
