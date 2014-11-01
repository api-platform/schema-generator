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
     */
    private $eligibleQuantity;
    /**
     */
    private $eligibleTransactionVolume;
    /**
     */
    private $maxPrice;
    /**
     */
    private $minPrice;
    /**
     */
    private $price;
    /**
     */
    private $validFrom;
    /**
     */
    private $validThrough;
    /**
     */
    private $valueAddedTaxIncluded;
    /**
     */
    private $priceCurrency;
}
