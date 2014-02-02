<?php

namespace SchemaOrg;

/**
 * Vote Action
 *
 * @link http://schema.org/VoteAction
 */
class VoteAction extends ChooseAction
{
    /**
     * Candidate
     *
     * @var Person A sub property of object. The candidate subject of this action.
     */
    protected $candidate;
}
