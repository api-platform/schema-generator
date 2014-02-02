<?php

namespace SchemaOrg;

/**
 * Artery
 *
 * @link http://schema.org/Artery
 */
class Artery extends Vessel
{
    /**
     * Arterial Branch
     *
     * @var AnatomicalStructure The branches that comprise the arterial structure.
     */
    protected $arterialBranch;
    /**
     * Source
     *
     * @var AnatomicalStructure The anatomical or organ system that the artery originates from.
     */
    protected $source;
    /**
     * Supply to
     *
     * @var AnatomicalStructure The area to which the artery supplies blood to.
     */
    protected $supplyTo;
}
