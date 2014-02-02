<?php

namespace SchemaOrg;

/**
 * Insert Action
 *
 * @link http://schema.org/InsertAction
 */
class InsertAction extends AddAction
{
    /**
     * To Location (Place)
     *
     * @var Place A sub property of location. The final location of the object or the agent after the action.
     */
    protected $toLocationPlace;
    /**
     * To Location (Number)
     *
     * @var float A sub property of location. The final location of the object or the agent after the action.
     */
    protected $toLocationNumber;
}
