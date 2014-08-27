<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A single, identifiable product instance (e.g. a laptop with a particular serial number).
 * 
 * @see http://schema.org/IndividualProduct Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class IndividualProduct extends Product
{
    /**
     * @type string $serialNumber The serial number or any alphanumeric identifier of a particular product. When attached to an offer, it is a shortcut for the serial number of the product included in the offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $serialNumber;
}
