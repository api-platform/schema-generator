<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A structured value indicating the quantity, unit of measurement, and business function of goods included in a bundle offer.
 * 
 * @see http://schema.org/TypeAndQuantityNode Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TypeAndQuantityNode extends StructuredValue
{
    /**
     * @type float $amountOfThisGood The quantity of the goods included in the offer.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $amountOfThisGood;
    /**
     * @type BusinessFunction $businessFunction The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.
     * @ORM\ManyToOne(targetEntity="BusinessFunction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $businessFunction;
    /**
     * @type Product $typeOfGood The product that this structured value is referring to.
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeOfGood;
    /**
     * @type string $unitCode The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $unitCode;
}
