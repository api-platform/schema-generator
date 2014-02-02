<?php

namespace SchemaOrg;

/**
 * Order
 *
 * @link http://schema.org/Order
 */
class Order extends Intangible
{
    /**
     * Accepted Offer
     *
     * @var Offer The offer(s) -- e.g., product, quantity and price combinations -- included in the order.
     */
    protected $acceptedOffer;
    /**
     * Billing Address
     *
     * @var PostalAddress The billing address for the order.
     */
    protected $billingAddress;
    /**
     * Confirmation Number
     *
     * @var string A number that confirms the given order.
     */
    protected $confirmationNumber;
    /**
     * Customer (Organization)
     *
     * @var Organization Party placing the order.
     */
    protected $customerOrganization;
    /**
     * Customer (Person)
     *
     * @var Person Party placing the order.
     */
    protected $customerPerson;
    /**
     * Discount (Number)
     *
     * @var float Any discount applied (to an Order).
     */
    protected $discountNumber;
    /**
     * Discount (Text)
     *
     * @var string Any discount applied (to an Order).
     */
    protected $discountText;
    /**
     * Discount Code
     *
     * @var string Code used to redeem a discount.
     */
    protected $discountCode;
    /**
     * Discount Currency
     *
     * @var string The currency (in 3-letter ISO 4217 format) of the discount.
     */
    protected $discountCurrency;
    /**
     * Is Gift
     *
     * @var boolean Was the offer accepted as a gift for someone other than the buyer.
     */
    protected $isGift;
    /**
     * Merchant (Organization)
     *
     * @var Organization The party taking the order (e.g. Amazon.com is a merchant for many sellers).
     */
    protected $merchantOrganization;
    /**
     * Merchant (Person)
     *
     * @var Person The party taking the order (e.g. Amazon.com is a merchant for many sellers).
     */
    protected $merchantPerson;
    /**
     * Order Date
     *
     * @var \DateTime Date order was placed.
     */
    protected $orderDate;
    /**
     * Ordered Item
     *
     * @var Product The item ordered.
     */
    protected $orderedItem;
    /**
     * Order Number
     *
     * @var string The identifier of the transaction.
     */
    protected $orderNumber;
    /**
     * Order Status
     *
     * @var OrderStatus The current status of the order.
     */
    protected $orderStatus;
    /**
     * Payment Due
     *
     * @var \DateTime The date that payment is due.
     */
    protected $paymentDue;
    /**
     * Payment Method
     *
     * @var PaymentMethod The name of the credit card or other method of payment for the order.
     */
    protected $paymentMethod;
    /**
     * Payment Method Id
     *
     * @var string An identifier for the method of payment used (e.g. the last 4 digits of the credit card).
     */
    protected $paymentMethodId;
    /**
     * Payment Url
     *
     * @var string The URL for sending a payment.
     */
    protected $paymentUrl;
}
