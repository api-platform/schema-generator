<?php

namespace SchemaOrg;

/**
 * Play Action
 *
 * @link http://schema.org/PlayAction
 */
class PlayAction extends Action
{
    /**
     * Audience
     *
     * @var Audience The intended audience of the item, i.e. the group for whom the item was created.
     */
    protected $audience;
    /**
     * Event
     *
     * @var Event Upcoming or past event associated with this place or organization.
     */
    protected $event;
}
