<?php

namespace SchemaOrg;

/**
 * Delivery Event
 *
 * @link http://schema.org/DeliveryEvent
 */
class DeliveryEvent extends Event
{
    /**
     * Access Code
     *
     * @var string Password, PIN, or access code needed for delivery (e.g. from a locker).
     */
    protected $accessCode;
    /**
     * Available From
     *
     * @var \DateTime When the item is available for pickup from the store, locker, etc.
     */
    protected $availableFrom;
    /**
     * Available Through
     *
     * @var \DateTime After this date, the item will no longer be available for pickup.
     */
    protected $availableThrough;
    /**
     * Has Delivery Method
     *
     * @var DeliveryMethod Method used for delivery or shipping.
     */
    protected $hasDeliveryMethod;
}
