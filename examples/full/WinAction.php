<?php

namespace SchemaOrg;

/**
 * Win Action
 *
 * @link http://schema.org/WinAction
 */
class WinAction extends AchieveAction
{
    /**
     * Loser
     *
     * @var Person A sub property of participant. The loser of the action.
     */
    protected $loser;
}
