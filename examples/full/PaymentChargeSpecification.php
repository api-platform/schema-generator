<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Payment Charge Specification
 * 
 * @link http://schema.org/PaymentChargeSpecification
 * 
 * @ORM\Entity
 */
class PaymentChargeSpecification extends PriceSpecification
{
    /**
     * Applies to Delivery Method
     * 
     * @var DeliveryMethod $appliesToDeliveryMethod The delivery method(s) to which the delivery charge or payment charge specification applies.
     * 
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $appliesToDeliveryMethod;
    /**
     * Applies to Payment Method
     * 
     * @var PaymentMethod $appliesToPaymentMethod The payment method(s) to which the payment charge specification applies.
     * 
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appliesToPaymentMethod;
}
