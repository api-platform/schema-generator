<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The delivery of a parcel either via the postal service or a commercial service.
 * 
 * @see http://schema.org/ParcelDelivery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ParcelDelivery extends Intangible
{
    /**
     * @type Organization $carrier 'carrier' is an out-dated term indicating the 'provider' for parcel delivery and flights.
     */
    private $carrier;
    /**
     * @type PostalAddress $deliveryAddress Destination address.
     */
    private $deliveryAddress;
    /**
     * @type DeliveryEvent $deliveryStatus New entry added as the package passes through each leg of its journey (from shipment to final delivery).
     */
    private $deliveryStatus;
    /**
     * @type \DateTime $expectedArrivalFrom The earliest date the package may arrive.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $expectedArrivalFrom;
    /**
     * @type \DateTime $expectedArrivalUntil The latest date the package may arrive.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $expectedArrivalUntil;
    /**
     * @type DeliveryMethod $hasDeliveryMethod Method used for delivery or shipping.
     */
    private $hasDeliveryMethod;
    /**
     * @type Product $itemShipped Item(s) being shipped.
     */
    private $itemShipped;
    /**
     * @type PostalAddress $originAddress Shipper's address.
     */
    private $originAddress;
    /**
     * @type Order $partOfOrder The overall order the items in this delivery were included in.
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfOrder;
    /**
     * @type string $trackingNumber Shipper tracking number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $trackingNumber;
    /**
     * @type string $trackingUrl Tracking url for the parcel delivery.
     * @Assert\Url
     * @ORM\Column
     */
    private $trackingUrl;
    /**
     * @type Person $provider The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $provider;
}
