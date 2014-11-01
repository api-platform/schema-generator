<?php

/*
 * This file is part of the Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Echoppe\CoreBundle\Model\PaymentChargeSpecificationInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class PaymentChargeSpecification extends PriceSpecification implements PaymentChargeSpecificationInterface
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

    /**
     * Sets appliesToDeliveryMethod.
     *
     * @param  string $appliesToDeliveryMethod
     * @return $this
     */
    public function setAppliesToDeliveryMethod($appliesToDeliveryMethod)
    {
        $this->appliesToDeliveryMethod = $appliesToDeliveryMethod;

        return $this;
    }

    /**
    * Gets appliesToDeliveryMethod.
    *
    * @return string
    */
    public function getAppliesToDeliveryMethod()
    {
        return $this->appliesToDeliveryMethod;
    }

    /**
     * Sets appliesToPaymentMethod.
     *
     * @param  string $appliesToPaymentMethod
     * @return $this
     */
    public function setAppliesToPaymentMethod($appliesToPaymentMethod)
    {
        $this->appliesToPaymentMethod = $appliesToPaymentMethod;

        return $this;
    }

    /**
    * Gets appliesToPaymentMethod.
    *
    * @return string
    */
    public function getAppliesToPaymentMethod()
    {
        return $this->appliesToPaymentMethod;
    }
}
