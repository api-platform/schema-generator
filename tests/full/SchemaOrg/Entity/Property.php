<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A property, used to indicate attributes and relationships of some Thing; equivalent to rdf:Property.
 * 
 * @see http://schema.org/Property Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Property extends Intangible
{
    /**
     */
    private $domainIncludes;
    /**
     */
    private $inverseOf;
    /**
     */
    private $supersededBy;
    /**
     */
    private $rangeIncludes;
}
