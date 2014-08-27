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
 * The costs of settling the payment using a particular payment method.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/PaymentChargeSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PaymentChargeSpecification extends PriceSpecification
{
    /**
     * @type string $appliesToDeliveryMethod The delivery method(s) to which the delivery charge or payment charge specification applies.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $appliesToDeliveryMethod;
    /**
     * @type string $appliesToPaymentMethod The payment method(s) to which the payment charge specification applies.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $appliesToPaymentMethod;
}
