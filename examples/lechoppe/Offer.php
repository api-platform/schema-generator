<?php

/*
 * This file is part of the L'Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Entity;

/**
 * Offer
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/Offer
 */
class Offer extends Intangible
{
    /**
     * Accepted Payment Method
     *
     * @var PaymentMethod The payment method(s) accepted by seller for this offer.
     */
    protected $acceptedPaymentMethod;
    /**
     * Add On
     *
     * @var Offer An additional offer that can only be obtained in combination with the first base offer (e.g. supplements and extensions that are available for a surcharge).
     */
    protected $addOn;
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
     * Available Delivery Method
     *
     * @var DeliveryMethod The delivery method(s) available for this offer.
     */
    protected $availableDeliveryMethod;
    /**
     * Category (Text)
     *
     * @var string A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     */
    protected $categoryText;
    /**
     * Category (Thing)
     *
     * @var Thing A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     */
    protected $categoryThing;
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
     * Eligible Region
     *
     * @var string The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     */
    protected $eligibleRegion;
    /**
     * Eligible Transaction Volume
     *
     * @var PriceSpecification The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.
     */
    protected $eligibleTransactionVolume;
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
     * Price Specification
     *
     * @var PriceSpecification One or more detailed price specifications, indicating the unit price and delivery or payment charges.
     */
    protected $priceSpecification;
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
