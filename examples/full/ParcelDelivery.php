<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Parcel Delivery
 * 
 * @link http://schema.org/ParcelDelivery
 * 
 * @ORM\Entity
 */
class ParcelDelivery extends Intangible
{
    /**
     * Carrier
     * 
     * @var Organization $carrier The party responsible for the parcel delivery.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carrier;
    /**
     * Delivery Address
     * 
     * @var PostalAddress $deliveryAddress Destination address.
     * 
     */
    private $deliveryAddress;
    /**
     * Delivery Status
     * 
     * @var DeliveryEvent $deliveryStatus New entry added as the package passes through each leg of its journey (from shipment to final delivery).
     * 
     */
    private $deliveryStatus;
    /**
     * Expected Arrival From
     * 
     * @var \DateTime $expectedArrivalFrom The earliest date the package may arrive.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $expectedArrivalFrom;
    /**
     * Expected Arrival Until
     * 
     * @var \DateTime $expectedArrivalUntil The latest date the package may arrive.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $expectedArrivalUntil;
    /**
     * Has Delivery Method
     * 
     * @var DeliveryMethod $hasDeliveryMethod Method used for delivery or shipping.
     * 
     */
    private $hasDeliveryMethod;
    /**
     * Item Shipped
     * 
     * @var Product $itemShipped Item(s) being shipped.
     * 
     */
    private $itemShipped;
    /**
     * Origin Address
     * 
     * @var PostalAddress $originAddress Shipper's address.
     * 
     */
    private $originAddress;
    /**
     * Part of Order
     * 
     * @var Order $partOfOrder The overall order the items in this delivery were included in.
     * 
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfOrder;
    /**
     * Tracking Number
     * 
     * @var string $trackingNumber Shipper tracking number.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $trackingNumber;
    /**
     * Tracking Url
     * 
     * @var string $trackingUrl Tracking url for the parcel delivery.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $trackingUrl;
}
