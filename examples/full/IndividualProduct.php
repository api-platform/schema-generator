<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Individual Product
 * 
 * @link http://schema.org/IndividualProduct
 * 
 * @ORM\Entity
 */
class IndividualProduct extends Product
{
    /**
     * Serial Number
     * 
     * @var string $serialNumber The serial number or any alphanumeric identifier of a particular product. When attached to an offer, it is a shortcut for the serial number of the product included in the offer.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $serialNumber;
}
