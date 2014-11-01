<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A demand entity represents the public, not necessarily binding, not necessarily exclusive, announcement by an organization or person to seek a certain type of goods or services. For describing demand using this type, the very same properties used for Offer apply.
 * 
 * @see http://schema.org/Demand Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Demand extends Intangible
{
    /**
     */
    private $acceptedPaymentMethod;
    /**
     */
    private $advanceBookingRequirement;
    /**
     */
    private $availability;
    /**
     */
    private $availabilityEnds;
    /**
     */
    private $availabilityStarts;
    /**
     */
    private $availableAtOrFrom;
    /**
     */
    private $availableDeliveryMethod;
    /**
     */
    private $businessFunction;
    /**
     */
    private $deliveryLeadTime;
    /**
     */
    private $eligibleCustomerType;
    /**
     */
    private $eligibleDuration;
    /**
     */
    private $eligibleQuantity;
    /**
     */
    private $eligibleRegion;
    /**
     */
    private $eligibleTransactionVolume;
    /**
     */
    private $gtin13;
    /**
     */
    private $gtin14;
    /**
     */
    private $gtin8;
    /**
     */
    private $includesObject;
    /**
     */
    private $inventoryLevel;
    /**
     */
    private $itemCondition;
    /**
     */
    private $itemOffered;
    /**
     */
    private $mpn;
    /**
     */
    private $priceSpecification;
    /**
     */
    private $seller;
    /**
     */
    private $serialNumber;
    /**
     */
    private $sku;
    /**
     */
    private $validFrom;
    /**
     */
    private $validThrough;
    /**
     */
    private $warranty;
}
