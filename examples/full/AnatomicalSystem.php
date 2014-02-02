<?php

namespace SchemaOrg;

/**
 * Anatomical System
 *
 * @link http://schema.org/AnatomicalSystem
 */
class AnatomicalSystem extends MedicalEntity
{
    /**
     * Associated Pathophysiology
     *
     * @var string If applicable, a description of the pathophysiology associated with the anatomical system, including potential abnormal changes in the mechanical, physical, and biochemical functions of the system.
     */
    protected $associatedPathophysiology;
    /**
     * Comprised of (AnatomicalStructure)
     *
     * @var AnatomicalStructure The underlying anatomical structures, such as organs, that comprise the anatomical system.
     */
    protected $comprisedOfAnatomicalStructure;
    /**
     * Comprised of (AnatomicalSystem)
     *
     * @var AnatomicalSystem The underlying anatomical structures, such as organs, that comprise the anatomical system.
     */
    protected $comprisedOfAnatomicalSystem;
    /**
     * Related Condition
     *
     * @var MedicalCondition A medical condition associated with this anatomy.
     */
    protected $relatedCondition;
    /**
     * Related Structure
     *
     * @var AnatomicalStructure Related anatomical structure(s) that are not part of the system but relate or connect to it, such as vascular bundles associated with an organ system.
     */
    protected $relatedStructure;
    /**
     * Related Therapy
     *
     * @var MedicalTherapy A medical therapy related to this anatomy.
     */
    protected $relatedTherapy;
}
