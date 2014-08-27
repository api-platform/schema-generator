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
 * The price for the delivery of an offer using a particular delivery method.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/DeliveryChargeSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DeliveryChargeSpecification extends PriceSpecification
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
}
