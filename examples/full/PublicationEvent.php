<?php

namespace SchemaOrg;

/**
 * Publication Event
 *
 * @link http://schema.org/PublicationEvent
 */
class PublicationEvent extends Event
{
    /**
     * Free
     *
     * @var boolean A flag to signal that the publication is accessible for free.
     */
    protected $free;
    /**
     * Published On
     *
     * @var BroadcastService A broadcast service associated with the publication event
     */
    protected $publishedOn;
}
