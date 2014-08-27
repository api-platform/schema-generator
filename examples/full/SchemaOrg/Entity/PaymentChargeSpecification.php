<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The costs of settling the payment using a particular payment method.
 * 
 * @see http://schema.org/PaymentChargeSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PaymentChargeSpecification extends PriceSpecification
{
    /**
     * @type DeliveryMethod $appliesToDeliveryMethod The delivery method(s) to which the delivery charge or payment charge specification applies.
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $appliesToDeliveryMethod;
    /**
     * @type PaymentMethod $appliesToPaymentMethod The payment method(s) to which the payment charge specification applies.
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appliesToPaymentMethod;
}
