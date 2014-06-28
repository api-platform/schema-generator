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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/Offer
 * 
 * @ORM\MappedSuperclass
 */
class Offer extends Thing
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
     * Add On
     * 
     * @var Offer $addOn An additional offer that can only be obtained in combination with the first base offer (e.g. supplements and extensions that are available for a surcharge).
     * 
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $addOn;
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
     * Available Delivery Method
     * 
     * @var DeliveryMethod $availableDeliveryMethod The delivery method(s) available for this offer.
     * 
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $availableDeliveryMethod;
    /**
     * Category
     * 
     * @var string $category A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $category;
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
     * Price Specification
     * 
     * @var PriceSpecification $priceSpecification One or more detailed price specifications, indicating the unit price and delivery or payment charges.
     * 
     * @ORM\ManyToOne(targetEntity="PriceSpecification")
     */
    private $priceSpecification;
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
}
