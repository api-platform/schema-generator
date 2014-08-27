<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The price asked for a given offer by the respective organization or person.
 * 
 * @see http://schema.org/UnitPriceSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UnitPriceSpecification extends PriceSpecification
{
    /**
     * @type float $billingIncrement This property specifies the minimal quantity and rounding increment that will be the basis for the billing. The unit of measurement is specified by the unitCode property.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $billingIncrement;
    /**
     * @type string $priceType A short text or acronym indicating multiple price specifications for the same offer, e.g. SRP for the suggested retail price or INVOICE for the invoice price, mostly used in the car industry.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $priceType;
    /**
     * @type string $unitCode The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $unitCode;
}
