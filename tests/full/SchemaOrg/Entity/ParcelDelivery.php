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
     */
    private $carrier;
    /**
     */
    private $deliveryAddress;
    /**
     */
    private $deliveryStatus;
    /**
     */
    private $expectedArrivalFrom;
    /**
     */
    private $expectedArrivalUntil;
    /**
     */
    private $hasDeliveryMethod;
    /**
     */
    private $itemShipped;
    /**
     */
    private $originAddress;
    /**
     */
    private $partOfOrder;
    /**
     */
    private $trackingNumber;
    /**
     */
    private $trackingUrl;
    /**
     */
    private $provider;
}
