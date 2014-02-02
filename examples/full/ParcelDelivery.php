<?php

namespace SchemaOrg;

/**
 * Parcel Delivery
 *
 * @link http://schema.org/ParcelDelivery
 */
class ParcelDelivery extends Intangible
{
    /**
     * Carrier
     *
     * @var Organization The party responsible for the parcel delivery.
     */
    protected $carrier;
    /**
     * Delivery Address
     *
     * @var PostalAddress Destination address.
     */
    protected $deliveryAddress;
    /**
     * Delivery Status
     *
     * @var DeliveryEvent New entry added as the package passes through each leg of its journey (from shipment to final delivery).
     */
    protected $deliveryStatus;
    /**
     * Expected Arrival From
     *
     * @var \DateTime The earliest date the package may arrive.
     */
    protected $expectedArrivalFrom;
    /**
     * Expected Arrival Until
     *
     * @var \DateTime The latest date the package may arrive.
     */
    protected $expectedArrivalUntil;
    /**
     * Has Delivery Method
     *
     * @var DeliveryMethod Method used for delivery or shipping.
     */
    protected $hasDeliveryMethod;
    /**
     * Item Shipped
     *
     * @var Product Item(s) being shipped.
     */
    protected $itemShipped;
    /**
     * Origin Address
     *
     * @var PostalAddress Shipper's address.
     */
    protected $originAddress;
    /**
     * Part of Order
     *
     * @var Order The overall order the items in this delivery were included in.
     */
    protected $partOfOrder;
    /**
     * Tracking Number
     *
     * @var string Shipper tracking number.
     */
    protected $trackingNumber;
    /**
     * Tracking Url
     *
     * @var string Tracking url for the parcel delivery.
     */
    protected $trackingUrl;
}
