<?php

namespace SchemaOrg;

/**
 * Payment Charge Specification
 *
 * @link http://schema.org/PaymentChargeSpecification
 */
class PaymentChargeSpecification extends PriceSpecification
{
    /**
     * Applies to Delivery Method
     *
     * @var DeliveryMethod The delivery method(s) to which the delivery charge or payment charge specification applies.
     */
    protected $appliesToDeliveryMethod;
    /**
     * Applies to Payment Method
     *
     * @var PaymentMethod The payment method(s) to which the payment charge specification applies.
     */
    protected $appliesToPaymentMethod;
}
