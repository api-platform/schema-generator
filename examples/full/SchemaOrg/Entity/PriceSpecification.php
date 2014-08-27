<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A structured value representing a monetary amount. Typically, only the subclasses of this type are used for markup.
 * 
 * @see http://schema.org/PriceSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PriceSpecification extends StructuredValue
{
    /**
     * @type QuantitativeValue $eligibleQuantity The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $eligibleQuantity;
    /**
     * @type PriceSpecification $eligibleTransactionVolume The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.
     * @ORM\OneToOne(targetEntity="PriceSpecification")
     */
    private $eligibleTransactionVolume;
    /**
     * @type float $maxPrice The highest price if the price is a range.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $maxPrice;
    /**
     * @type float $minPrice The lowest price if the price is a range.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $minPrice;
    /**
     * @type float $price The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $price;
    /**
     * @type \DateTime $validFrom The date when the item becomes valid.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * @type \DateTime $validThrough The end of the validity of offer, price specification, or opening hours data.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validThrough;
    /**
     * @type boolean $valueAddedTaxIncluded Specifies whether the applicable value-added tax (VAT) is included in the price specification or not.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $valueAddedTaxIncluded;
    /**
     * @type string $priceCurrency The currency (in 3-letter ISO 4217 format) of the price or a price component, when attached to PriceSpecification and its subtypes.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $priceCurrency;
}
