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
     */
    private $appliesToDeliveryMethod;
    /**
     */
    private $appliesToPaymentMethod;
}
