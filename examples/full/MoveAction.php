<?php

namespace SchemaOrg;

/**
 * Move Action
 *
 * @link http://schema.org/MoveAction
 */
class MoveAction extends Action
{
    /**
     * From Location (Place)
     *
     * @var Place A sub property of location. The original location of the object or the agent before the action.
     */
    protected $fromLocationPlace;
    /**
     * From Location (Number)
     *
     * @var float A sub property of location. The original location of the object or the agent before the action.
     */
    protected $fromLocationNumber;
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
