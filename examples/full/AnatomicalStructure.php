<?php

namespace SchemaOrg;

/**
 * Anatomical Structure
 *
 * @link http://schema.org/AnatomicalStructure
 */
class AnatomicalStructure extends MedicalEntity
{
    /**
     * Associated Pathophysiology
     *
     * @var string If applicable, a description of the pathophysiology associated with the anatomical system, including potential abnormal changes in the mechanical, physical, and biochemical functions of the system.
     */
    protected $associatedPathophysiology;
    /**
     * Body Location
     *
     * @var string Location in the body of the anatomical structure.
     */
    protected $bodyLocation;
    /**
     * Connected to
     *
     * @var AnatomicalStructure Other anatomical structures to which this structure is connected.
     */
    protected $connectedTo;
    /**
     * Diagram
     *
     * @var ImageObject An image containing a diagram that illustrates the structure and/or its component substructures and/or connections with other structures.
     */
    protected $diagram;
    /**
     * Function
     *
     * @var string Function of the anatomical structure.
     */
    protected $function;
    /**
     * Part of System
     *
     * @var AnatomicalSystem The anatomical or organ system that this structure is part of.
     */
    protected $partOfSystem;
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
     * Sub Structure
     *
     * @var AnatomicalStructure Component (sub-)structure(s) that comprise this anatomical structure.
     */
    protected $subStructure;
}
