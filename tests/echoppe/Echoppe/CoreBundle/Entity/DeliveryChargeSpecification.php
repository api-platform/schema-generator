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
use Echoppe\CoreBundle\Model\DeliveryChargeSpecificationInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class DeliveryChargeSpecification extends PriceSpecification implements DeliveryChargeSpecificationInterface
{
    /**
     * @type string $appliesToDeliveryMethod The delivery method(s) to which the delivery charge or payment charge specification applies.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $appliesToDeliveryMethod;
    /**
     * @type string $eligibleRegion The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $eligibleRegion;

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
     * Sets eligibleRegion.
     *
     * @param  string $eligibleRegion
     * @return $this
     */
    public function setEligibleRegion($eligibleRegion)
    {
        $this->eligibleRegion = $eligibleRegion;

        return $this;
    }

    /**
    * Gets eligibleRegion.
    *
    * @return string
    */
    public function getEligibleRegion()
    {
        return $this->eligibleRegion;
    }
}
