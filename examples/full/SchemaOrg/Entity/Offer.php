<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An offer to transfer some rights to an item or to provide a service&#x2014;for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
 * 
 * @see http://schema.org/Offer Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Offer extends Intangible
{
    /**
     * @type PaymentMethod $acceptedPaymentMethod The payment method(s) accepted by seller for this offer.
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     */
    private $acceptedPaymentMethod;
    /**
     * @type Offer $addOn An additional offer that can only be obtained in combination with the first base offer (e.g. supplements and extensions that are available for a surcharge).
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $addOn;
    /**
     * @type QuantitativeValue $advanceBookingRequirement The amount of time that is required between accepting the offer and the actual usage of the resource or service.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $advanceBookingRequirement;
    /**
     * @type AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * @type ItemAvailability $availability The availability of this item&#x2014;for example In stock, Out of stock, Pre-order, etc.
     * @ORM\ManyToOne(targetEntity="ItemAvailability")
     * @ORM\JoinColumn(nullable=false)
     */
    private $availability;
    /**
     * @type \DateTime $availabilityEnds The end of the availability of the product or service included in the offer.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availabilityEnds;
    /**
     * @type \DateTime $availabilityStarts The beginning of the availability of the product or service included in the offer.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availabilityStarts;
    /**
     * @type Place $availableAtOrFrom The place(s) from which the offer can be obtained (e.g. store locations).
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $availableAtOrFrom;
    /**
     * @type DeliveryMethod $availableDeliveryMethod The delivery method(s) available for this offer.
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $availableDeliveryMethod;
    /**
     * @type BusinessFunction $businessFunction The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.
     * @ORM\ManyToOne(targetEntity="BusinessFunction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $businessFunction;
    /**
     * @type PhysicalActivityCategory $category A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     * @ORM\ManyToOne(targetEntity="PhysicalActivityCategory")
     */
    private $category;
    /**
     * @type QuantitativeValue $deliveryLeadTime The typical delay between the receipt of the order and the goods leaving the warehouse.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $deliveryLeadTime;
    /**
     * @type BusinessEntityType $eligibleCustomerType The type(s) of customers for which the given offer is valid.
     * @ORM\ManyToOne(targetEntity="BusinessEntityType")
     */
    private $eligibleCustomerType;
    /**
     * @type QuantitativeValue $eligibleDuration The duration for which the given offer is valid.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $eligibleDuration;
    /**
     * @type QuantitativeValue $eligibleQuantity The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $eligibleQuantity;
    /**
     * @type GeoShape $eligibleRegion The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     * @ORM\ManyToOne(targetEntity="GeoShape")
     */
    private $eligibleRegion;
    /**
     * @type PriceSpecification $eligibleTransactionVolume The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.
     * @ORM\OneToOne(targetEntity="PriceSpecification")
     */
    private $eligibleTransactionVolume;
    /**
     * @type string $gtin13 The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin13;
    /**
     * @type string $gtin14 The GTIN-14 code of the product, or the product to which the offer refers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin14;
    /**
     * @type string $gtin8 The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin8;
    /**
     * @type TypeAndQuantityNode $includesObject This links to a node or nodes indicating the exact quantity of the products included in the offer.
     * @ORM\ManyToOne(targetEntity="TypeAndQuantityNode")
     */
    private $includesObject;
    /**
     * @type QuantitativeValue $inventoryLevel The current approximate inventory level for the item or items.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $inventoryLevel;
    /**
     * @type OfferItemCondition $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * @ORM\ManyToOne(targetEntity="OfferItemCondition")
     */
    private $itemCondition;
    /**
     * @type Product $itemOffered The item being offered.
     * @ORM\OneToOne(targetEntity="Product")
     */
    private $itemOffered;
    /**
     * @type string $mpn The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mpn;
    /**
     * @type float $price The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $price;
    /**
     * @type PriceSpecification $priceSpecification One or more detailed price specifications, indicating the unit price and delivery or payment charges.
     * @ORM\ManyToOne(targetEntity="PriceSpecification")
     */
    private $priceSpecification;
    /**
     * @type \DateTime $priceValidUntil The date after which the price is no longer available.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $priceValidUntil;
    /**
     * @type Review $review A review of the item.
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
    /**
     * @type Organization $seller An entity which offers (sells / leases / lends / loans) the services / goods.  A seller may also be a provider.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $seller;
    /**
     * @type string $serialNumber The serial number or any alphanumeric identifier of a particular product. When attached to an offer, it is a shortcut for the serial number of the product included in the offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $serialNumber;
    /**
     * @type string $sku The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $sku;
    /**
     * @type \DateTime $validFrom The date when the item becomes valid.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * @type \DateTime $validThrough The end of the validity of offer, price specification, or opening hours data.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validThrough;
    /**
     * @type WarrantyPromise $warranty The warranty promise(s) included in the offer.
     * @ORM\ManyToOne(targetEntity="WarrantyPromise")
     */
    private $warranty;
    /**
     * @type string $priceCurrency The currency (in 3-letter ISO 4217 format) of the price or a price component, when attached to PriceSpecification and its subtypes.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $priceCurrency;
}
