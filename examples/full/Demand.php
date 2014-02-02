<?php

namespace SchemaOrg;

/**
 * Demand
 *
 * @link http://schema.org/Demand
 */
class Demand extends Intangible
{
    /**
     * Accepted Payment Method
     *
     * @var PaymentMethod The payment method(s) accepted by seller for this offer.
     */
    protected $acceptedPaymentMethod;
    /**
     * Advance Booking Requirement
     *
     * @var QuantitativeValue The amount of time that is required between accepting the offer and the actual usage of the resource or service.
     */
    protected $advanceBookingRequirement;
    /**
     * Availability
     *
     * @var ItemAvailability The availability of this item—for example In stock, Out of stock, Pre-order, etc.
     */
    protected $availability;
    /**
     * Availability Ends
     *
     * @var \DateTime The end of the availability of the product or service included in the offer.
     */
    protected $availabilityEnds;
    /**
     * Availability Starts
     *
     * @var \DateTime The beginning of the availability of the product or service included in the offer.
     */
    protected $availabilityStarts;
    /**
     * Available At or From
     *
     * @var Place The place(s) from which the offer can be obtained (e.g. store locations).
     */
    protected $availableAtOrFrom;
    /**
     * Available Delivery Method
     *
     * @var DeliveryMethod The delivery method(s) available for this offer.
     */
    protected $availableDeliveryMethod;
    /**
     * Business Function
     *
     * @var BusinessFunction The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.
     */
    protected $businessFunction;
    /**
     * Delivery Lead Time
     *
     * @var QuantitativeValue The typical delay between the receipt of the order and the goods leaving the warehouse.
     */
    protected $deliveryLeadTime;
    /**
     * Eligible Customer Type
     *
     * @var BusinessEntityType The type(s) of customers for which the given offer is valid.
     */
    protected $eligibleCustomerType;
    /**
     * Eligible Duration
     *
     * @var QuantitativeValue The duration for which the given offer is valid.
     */
    protected $eligibleDuration;
    /**
     * Eligible Quantity
     *
     * @var QuantitativeValue The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.
     */
    protected $eligibleQuantity;
    /**
     * Eligible Region (Text)
     *
     * @var string The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     */
    protected $eligibleRegionText;
    /**
     * Eligible Region (GeoShape)
     *
     * @var GeoShape The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     */
    protected $eligibleRegionGeoShape;
    /**
     * Eligible Transaction Volume
     *
     * @var PriceSpecification The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.
     */
    protected $eligibleTransactionVolume;
    /**
     * Gtin13
     *
     * @var string The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero.
     */
    protected $gtin13;
    /**
     * Gtin14
     *
     * @var string The GTIN-14 code of the product, or the product to which the offer refers.
     */
    protected $gtin14;
    /**
     * Gtin8
     *
     * @var string The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN.
     */
    protected $gtin8;
    /**
     * Includes Object
     *
     * @var TypeAndQuantityNode This links to a node or nodes indicating the exact quantity of the products included in the offer.
     */
    protected $includesObject;
    /**
     * Inventory Level
     *
     * @var QuantitativeValue The current approximate inventory level for the item or items.
     */
    protected $inventoryLevel;
    /**
     * Item Condition
     *
     * @var OfferItemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     */
    protected $itemCondition;
    /**
     * Item Offered
     *
     * @var Product The item being sold.
     */
    protected $itemOffered;
    /**
     * Mpn
     *
     * @var string The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.
     */
    protected $mpn;
    /**
     * Price Specification
     *
     * @var PriceSpecification One or more detailed price specifications, indicating the unit price and delivery or payment charges.
     */
    protected $priceSpecification;
    /**
     * Seller (Organization)
     *
     * @var Organization The seller.
     */
    protected $sellerOrganization;
    /**
     * Seller (Person)
     *
     * @var Person The seller.
     */
    protected $sellerPerson;
    /**
     * Serial Number
     *
     * @var string The serial number or any alphanumeric identifier of a particular product. When attached to an offer, it is a shortcut for the serial number of the product included in the offer.
     */
    protected $serialNumber;
    /**
     * Sku
     *
     * @var string The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.
     */
    protected $sku;
    /**
     * Valid From
     *
     * @var \DateTime The date when the item becomes valid.
     */
    protected $validFrom;
    /**
     * Valid Through
     *
     * @var \DateTime The end of the validity of offer, price specification, or opening hours data.
     */
    protected $validThrough;
    /**
     * Warranty
     *
     * @var WarrantyPromise The warranty promise(s) included in the offer.
     */
    protected $warranty;
}
