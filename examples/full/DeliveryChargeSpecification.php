<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Delivery Charge Specification
 * 
 * @link http://schema.org/DeliveryChargeSpecification
 * 
 * @ORM\Entity
 */
class DeliveryChargeSpecification extends PriceSpecification
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
     * Eligible Region
     * 
     * @var string $eligibleRegion The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $eligibleRegion;
}
