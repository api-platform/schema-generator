<?php

namespace SchemaOrg;

/**
 * Track Action
 *
 * @link http://schema.org/TrackAction
 */
class TrackAction extends FindAction
{
    /**
     * Delivery Method
     *
     * @var DeliveryMethod A sub property of instrument. The method of delivery
     */
    protected $deliveryMethod;
}
