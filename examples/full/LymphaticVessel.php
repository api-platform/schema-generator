<?php

namespace SchemaOrg;

/**
 * Lymphatic Vessel
 *
 * @link http://schema.org/LymphaticVessel
 */
class LymphaticVessel extends Vessel
{
    /**
     * Originates From
     *
     * @var Vessel The vasculature the lymphatic structure originates, or afferents, from.
     */
    protected $originatesFrom;
    /**
     * Region Drained (AnatomicalSystem)
     *
     * @var AnatomicalSystem The anatomical or organ system drained by this vessel; generally refers to a specific part of an organ.
     */
    protected $regionDrainedAnatomicalSystem;
    /**
     * Region Drained (AnatomicalStructure)
     *
     * @var AnatomicalStructure The anatomical or organ system drained by this vessel; generally refers to a specific part of an organ.
     */
    protected $regionDrainedAnatomicalStructure;
    /**
     * Runs to
     *
     * @var Vessel The vasculature the lymphatic structure runs, or efferents, to.
     */
    protected $runsTo;
}
