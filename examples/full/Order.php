<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 * 
 * @link http://schema.org/Order
 * 
 * @ORM\Entity
 */
class Order extends Intangible
{
    /**
     * Accepted Offer
     * 
     * @var Offer $acceptedOffer The offer(s) -- e.g., product, quantity and price combinations -- included in the order.
     * 
     * @ORM\ManyToOne(targetEntity="Offer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acceptedOffer;
    /**
     * Billing Address
     * 
     * @var PostalAddress $billingAddress The billing address for the order.
     * 
     * @ORM\ManyToOne(targetEntity="PostalAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billingAddress;
    /**
     * Confirmation Number
     * 
     * @var string $confirmationNumber A number that confirms the given order.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $confirmationNumber;
    /**
     * Customer
     * 
     * @var Organization $customer Party placing the order.
     * 
     */
    private $customer;
    /**
     * Discount
     * 
     * @var float $discount Any discount applied (to an Order).
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $discount;
    /**
     * Discount Code
     * 
     * @var string $discountCode Code used to redeem a discount.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $discountCode;
    /**
     * Discount Currency
     * 
     * @var string $discountCurrency The currency (in 3-letter ISO 4217 format) of the discount.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $discountCurrency;
    /**
     * Is Gift
     * 
     * @var boolean $isGift Was the offer accepted as a gift for someone other than the buyer.
     * 
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isGift;
    /**
     * Merchant
     * 
     * @var Organization $merchant The party taking the order (e.g. Amazon.com is a merchant for many sellers).
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $merchant;
    /**
     * Order Date
     * 
     * @var \DateTime $orderDate Date order was placed.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $orderDate;
    /**
     * Ordered Item
     * 
     * @var Product $orderedItem The item ordered.
     * 
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderedItem;
    /**
     * Order Number
     * 
     * @var string $orderNumber The identifier of the transaction.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $orderNumber;
    /**
     * Order Status
     * 
     * @var OrderStatus $orderStatus The current status of the order.
     * 
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderStatus;
    /**
     * Payment Due
     * 
     * @var \DateTime $paymentDue The date that payment is due.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $paymentDue;
    /**
     * Payment Method
     * 
     * @var PaymentMethod $paymentMethod The name of the credit card or other method of payment for the order.
     * 
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentMethod;
    /**
     * Payment Method Id
     * 
     * @var string $paymentMethodId An identifier for the method of payment used (e.g. the last 4 digits of the credit card).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $paymentMethodId;
    /**
     * Payment Url
     * 
     * @var string $paymentUrl The URL for sending a payment.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $paymentUrl;
}
