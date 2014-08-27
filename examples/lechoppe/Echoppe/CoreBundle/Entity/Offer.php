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
 * An offer to transfer some rights to an item or to provide a service—for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/Offer Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Offer extends Thing
{
    /**
     * @type string $acceptedPaymentMethod The payment method(s) accepted by seller for this offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $acceptedPaymentMethod;
    /**
     * @type string $availability The availability of this item—for example In stock, Out of stock, Pre-order, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
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
     * @type string $availableDeliveryMethod The delivery method(s) available for this offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $availableDeliveryMethod;
    /**
     * @type string $category A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $category;
    /**
     * @type QuantitativeValue $deliveryLeadTime The typical delay between the receipt of the order and the goods leaving the warehouse.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $deliveryLeadTime;
    /**
     * @type QuantitativeValue $inventoryLevel The current approximate inventory level for the item or items.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $inventoryLevel;
    /**
     * @type string $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $itemCondition;
    /**
     * @type PriceSpecification $priceSpecification One or more detailed price specifications, indicating the unit price and delivery or payment charges.
     * @ORM\ManyToOne(targetEntity="PriceSpecification")
     */
    private $priceSpecification;
}
