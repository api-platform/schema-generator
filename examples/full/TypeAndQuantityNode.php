<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type And Quantity Node
 * 
 * @link http://schema.org/TypeAndQuantityNode
 * 
 * @ORM\Entity
 */
class TypeAndQuantityNode extends StructuredValue
{
    /**
     * Amount of This Good
     * 
     * @var float $amountOfThisGood The quantity of the goods included in the offer.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $amountOfThisGood;
    /**
     * Business Function
     * 
     * @var BusinessFunction $businessFunction The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.
     * 
     * @ORM\ManyToOne(targetEntity="BusinessFunction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $businessFunction;
    /**
     * Type of Good
     * 
     * @var Product $typeOfGood The product that this structured value is referring to.
     * 
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeOfGood;
    /**
     * Unit Code
     * 
     * @var string $unitCode The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $unitCode;
}
