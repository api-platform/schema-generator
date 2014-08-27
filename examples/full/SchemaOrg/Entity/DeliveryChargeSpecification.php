<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The price for the delivery of an offer using a particular delivery method.
 * 
 * @see http://schema.org/DeliveryChargeSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DeliveryChargeSpecification extends PriceSpecification
{
    /**
     * @type DeliveryMethod $appliesToDeliveryMethod The delivery method(s) to which the delivery charge or payment charge specification applies.
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $appliesToDeliveryMethod;
    /**
     * @type GeoShape $eligibleRegion The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     * @ORM\ManyToOne(targetEntity="GeoShape")
     */
    private $eligibleRegion;
}
