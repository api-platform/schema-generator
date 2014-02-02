<?php

namespace SchemaOrg;

/**
 * Nerve
 *
 * @link http://schema.org/Nerve
 */
class Nerve extends AnatomicalStructure
{
    /**
     * Branch (AnatomicalStructure)
     *
     * @var AnatomicalStructure The branches that delineate from the nerve bundle.
     */
    protected $branchAnatomicalStructure;
    /**
     * Branch (Nerve)
     *
     * @var Nerve The branches that delineate from the nerve bundle.
     */
    protected $branchNerve;
    /**
     * Nerve Motor
     *
     * @var Muscle The neurological pathway extension that involves muscle control.
     */
    protected $nerveMotor;
    /**
     * Sensory Unit (AnatomicalStructure)
     *
     * @var AnatomicalStructure The neurological pathway extension that inputs and sends information to the brain or spinal cord.
     */
    protected $sensoryUnitAnatomicalStructure;
    /**
     * Sensory Unit (SuperficialAnatomy)
     *
     * @var SuperficialAnatomy The neurological pathway extension that inputs and sends information to the brain or spinal cord.
     */
    protected $sensoryUnitSuperficialAnatomy;
    /**
     * Sourced From
     *
     * @var BrainStructure The neurological pathway that originates the neurons.
     */
    protected $sourcedFrom;
}
