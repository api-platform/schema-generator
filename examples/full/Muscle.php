<?php

namespace SchemaOrg;

/**
 * Muscle
 *
 * @link http://schema.org/Muscle
 */
class Muscle extends AnatomicalStructure
{
    /**
     * Action
     *
     * @var string The movement the muscle generates.
     */
    protected $action;
    /**
     * Antagonist
     *
     * @var Muscle The muscle whose action counteracts the specified muscle.
     */
    protected $antagonist;
    /**
     * Blood Supply
     *
     * @var Vessel The blood vessel that carries blood from the heart to the muscle.
     */
    protected $bloodSupply;
    /**
     * Insertion
     *
     * @var AnatomicalStructure The place of attachment of a muscle, or what the muscle moves.
     */
    protected $insertion;
    /**
     * Nerve
     *
     * @var Nerve The underlying innervation associated with the muscle.
     */
    protected $nerve;
    /**
     * Origin
     *
     * @var AnatomicalStructure The place or point where a muscle arises.
     */
    protected $origin;
}
