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
     */
    private $serialNumber;
}
