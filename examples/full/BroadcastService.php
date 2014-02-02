<?php

namespace SchemaOrg;

/**
 * Broadcast Service
 *
 * @link http://schema.org/BroadcastService
 */
class BroadcastService extends Thing
{
    /**
     * Area
     *
     * @var Place The area within which users can expect to reach the broadcast service.
     */
    protected $area;
    /**
     * Broadcaster
     *
     * @var Organization The organization owning or operating the broadcast service.
     */
    protected $broadcaster;
    /**
     * Parent Service
     *
     * @var BroadcastService A broadcast service to which the broadcast service may belong to such as regional variations of a national channel.
     */
    protected $parentService;
}
