<?php

namespace SchemaOrg;

/**
 * Choose Action
 *
 * @link http://schema.org/ChooseAction
 */
class ChooseAction extends AssessAction
{
    /**
     * Option (Text)
     *
     * @var string A sub property of object. The options subject to this action.
     */
    protected $optionText;
    /**
     * Option (Thing)
     *
     * @var Thing A sub property of object. The options subject to this action.
     */
    protected $optionThing;
}
