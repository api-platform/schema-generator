<?php

namespace SchemaOrg;

/**
 * Superficial Anatomy
 *
 * @link http://schema.org/SuperficialAnatomy
 */
class SuperficialAnatomy extends MedicalEntity
{
    /**
     * Associated Pathophysiology
     *
     * @var string If applicable, a description of the pathophysiology associated with the anatomical system, including potential abnormal changes in the mechanical, physical, and biochemical functions of the system.
     */
    protected $associatedPathophysiology;
    /**
     * Related Anatomy (AnatomicalStructure)
     *
     * @var AnatomicalStructure Anatomical systems or structures that relate to the superficial anatomy.
     */
    protected $relatedAnatomyAnatomicalStructure;
    /**
     * Related Anatomy (AnatomicalSystem)
     *
     * @var AnatomicalSystem Anatomical systems or structures that relate to the superficial anatomy.
     */
    protected $relatedAnatomyAnatomicalSystem;
    /**
     * Related Condition
     *
     * @var MedicalCondition A medical condition associated with this anatomy.
     */
    protected $relatedCondition;
    /**
     * Related Therapy
     *
     * @var MedicalTherapy A medical therapy related to this anatomy.
     */
    protected $relatedTherapy;
    /**
     * Significance
     *
     * @var string The significance associated with the superficial anatomy; as an example, how characteristics of the superficial anatomy can suggest underlying medical conditions or courses of treatment.
     */
    protected $significance;
}
