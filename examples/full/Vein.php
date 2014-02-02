<?php

namespace SchemaOrg;

/**
 * Vein
 *
 * @link http://schema.org/Vein
 */
class Vein extends Vessel
{
    /**
     * Drains to
     *
     * @var Vessel The vasculature that the vein drains into.
     */
    protected $drainsTo;
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
     * Tributary
     *
     * @var AnatomicalStructure The anatomical or organ system that the vein flows into; a larger structure that the vein connects to.
     */
    protected $tributary;
}
