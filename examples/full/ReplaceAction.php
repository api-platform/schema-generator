<?php

namespace SchemaOrg;

/**
 * Replace Action
 *
 * @link http://schema.org/ReplaceAction
 */
class ReplaceAction extends UpdateAction
{
    /**
     * Replacee
     *
     * @var Thing A sub property of object. The object that is being replaced.
     */
    protected $replacee;
    /**
     * Replacer
     *
     * @var Thing A sub property of object. The object that replaces.
     */
    protected $replacer;
}
