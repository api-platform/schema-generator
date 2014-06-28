<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Demand
 * 
 * @link http://schema.org/Demand
 * 
 * @ORM\Entity
 */
class Demand extends Intangible
{
    /**
     * Accepted Payment Method
     * 
     * @var PaymentMethod $acceptedPaymentMethod The payment method(s) accepted by seller for this offer.
     * 
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     */
    private $acceptedPaymentMethod;
    /**
     * Advance Booking Requirement
     * 
     * @var QuantitativeValue $advanceBookingRequirement The amount of time that is required between accepting the offer and the actual usage of the resource or service.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $advanceBookingRequirement;
    /**
     * Availability
     * 
     * @var ItemAvailability $availability The availability of this item—for example In stock, Out of stock, Pre-order, etc.
     * 
     * @ORM\ManyToOne(targetEntity="ItemAvailability")
     * @ORM\JoinColumn(nullable=false)
     */
    private $availability;
    /**
     * Availability Ends
     * 
     * @var \DateTime $availabilityEnds The end of the availability of the product or service included in the offer.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availabilityEnds;
    /**
     * Availability Starts
     * 
     * @var \DateTime $availabilityStarts The beginning of the availability of the product or service included in the offer.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availabilityStarts;
    /**
     * Available At or From
     * 
     * @var Place $availableAtOrFrom The place(s) from which the offer can be obtained (e.g. store locations).
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $availableAtOrFrom;
    /**
     * Available Delivery Method
     * 
     * @var DeliveryMethod $availableDeliveryMethod The delivery method(s) available for this offer.
     * 
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $availableDeliveryMethod;
    /**
     * Business Function
     * 
     * @var BusinessFunction $businessFunction The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.
     * 
     * @ORM\ManyToOne(targetEntity="BusinessFunction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $businessFunction;
    /**
     * Delivery Lead Time
     * 
     * @var QuantitativeValue $deliveryLeadTime The typical delay between the receipt of the order and the goods leaving the warehouse.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $deliveryLeadTime;
    /**
     * Eligible Customer Type
     * 
     * @var BusinessEntityType $eligibleCustomerType The type(s) of customers for which the given offer is valid.
     * 
     * @ORM\ManyToOne(targetEntity="BusinessEntityType")
     */
    private $eligibleCustomerType;
    /**
     * Eligible Duration
     * 
     * @var QuantitativeValue $eligibleDuration The duration for which the given offer is valid.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $eligibleDuration;
    /**
     * Eligible Quantity
     * 
     * @var QuantitativeValue $eligibleQuantity The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $eligibleQuantity;
    /**
     * Eligible Region
     * 
     * @var string $eligibleRegion The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $eligibleRegion;
    /**
     * Eligible Transaction Volume
     * 
     * @var PriceSpecification $eligibleTransactionVolume The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.
     * 
     * @ORM\OneToOne(targetEntity="PriceSpecification")
     */
    private $eligibleTransactionVolume;
    /**
     * Gtin13
     * 
     * @var string $gtin13 The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin13;
    /**
     * Gtin14
     * 
     * @var string $gtin14 The GTIN-14 code of the product, or the product to which the offer refers.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin14;
    /**
     * Gtin8
     * 
     * @var string $gtin8 The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin8;
    /**
     * Includes Object
     * 
     * @var TypeAndQuantityNode $includesObject This links to a node or nodes indicating the exact quantity of the products included in the offer.
     * 
     * @ORM\ManyToOne(targetEntity="TypeAndQuantityNode")
     */
    private $includesObject;
    /**
     * Inventory Level
     * 
     * @var QuantitativeValue $inventoryLevel The current approximate inventory level for the item or items.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $inventoryLevel;
    /**
     * Item Condition
     * 
     * @var OfferItemCondition $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * 
     * @ORM\ManyToOne(targetEntity="OfferItemCondition")
     */
    private $itemCondition;
    /**
     * Item Offered
     * 
     * @var Product $itemOffered The item being offered.
     * 
     * @ORM\OneToOne(targetEntity="Product")
     */
    private $itemOffered;
    /**
     * Mpn
     * 
     * @var string $mpn The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mpn;
    /**
     * Price Specification
     * 
     * @var PriceSpecification $priceSpecification One or more detailed price specifications, indicating the unit price and delivery or payment charges.
     * 
     * @ORM\ManyToOne(targetEntity="PriceSpecification")
     */
    private $priceSpecification;
    /**
     * Seller
     * 
     * @var Organization $seller The organization or person making the offer.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;
    /**
     * Serial Number
     * 
     * @var string $serialNumber The serial number or any alphanumeric identifier of a particular product. When attached to an offer, it is a shortcut for the serial number of the product included in the offer.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $serialNumber;
    /**
     * Sku
     * 
     * @var string $sku The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $sku;
    /**
     * Valid From
     * 
     * @var \DateTime $validFrom The date when the item becomes valid.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * Valid Through
     * 
     * @var \DateTime $validThrough The end of the validity of offer, price specification, or opening hours data.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validThrough;
    /**
     * Warranty
     * 
     * @var WarrantyPromise $warranty The warranty promise(s) included in the offer.
     * 
     * @ORM\ManyToOne(targetEntity="WarrantyPromise")
     */
    private $warranty;
}
