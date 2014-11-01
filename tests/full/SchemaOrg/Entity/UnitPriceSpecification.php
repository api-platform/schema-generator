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
     */
    private $billingIncrement;
    /**
     */
    private $priceType;
    /**
     */
    private $unitCode;
}
