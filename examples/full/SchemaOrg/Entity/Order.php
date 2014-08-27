<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An order is a confirmation of a transaction (a receipt), which can contain multiple line items, each represented by an Offer that has been accepted by the customer.
 * 
 * @see http://schema.org/Order Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Order extends Intangible
{
    /**
     * @type Offer $acceptedOffer The offer(s) -- e.g., product, quantity and price combinations -- included in the order.
     * @ORM\ManyToOne(targetEntity="Offer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acceptedOffer;
    /**
     * @type PostalAddress $billingAddress The billing address for the order.
     * @ORM\ManyToOne(targetEntity="PostalAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billingAddress;
    /**
     * @type string $confirmationNumber A number that confirms the given order.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $confirmationNumber;
    /**
     * @type Organization $customer Party placing the order.
     */
    private $customer;
    /**
     * @type float $discount Any discount applied (to an Order).
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $discount;
    /**
     * @type string $discountCode Code used to redeem a discount.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $discountCode;
    /**
     * @type string $discountCurrency The currency (in 3-letter ISO 4217 format) of the discount.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $discountCurrency;
    /**
     * @type boolean $isGift Was the offer accepted as a gift for someone other than the buyer.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isGift;
    /**
     * @type Organization $merchant 'merchant' is an out-dated term for 'seller'.
     */
    private $merchant;
    /**
     * @type \DateTime $orderDate Date order was placed.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $orderDate;
    /**
     * @type Product $orderedItem The item ordered.
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderedItem;
    /**
     * @type string $orderNumber The identifier of the transaction.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $orderNumber;
    /**
     * @type OrderStatus $orderStatus The current status of the order.
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderStatus;
    /**
     * @type \DateTime $paymentDue The date that payment is due.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $paymentDue;
    /**
     * @type PaymentMethod $paymentMethod The name of the credit card or other method of payment for the order.
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentMethod;
    /**
     * @type string $paymentMethodId An identifier for the method of payment used (e.g. the last 4 digits of the credit card).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $paymentMethodId;
    /**
     * @type string $paymentUrl The URL for sending a payment.
     * @Assert\Url
     * @ORM\Column
     */
    private $paymentUrl;
    /**
     * @type Organization $seller An entity which offers (sells / leases / lends / loans) the services / goods.  A seller may also be a provider.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $seller;
    /**
     * @type Person $broker An entity that arranges for an exchange between a buyer and a seller.  In most cases a broker never acquires or releases ownership of a product or service involved in an exchange.  If it is not clear whether an entity is a broker, seller, or buyer, the latter two terms are preferred.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $broker;
}
