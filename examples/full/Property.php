<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 * 
 * @link http://schema.org/Property
 * 
 * @ORM\Entity
 */
class Property extends Thing
{
    /**
     * Domain Includes
     * 
     * @var Class $domainIncludes Relates a property to a class that is (one of) the type(s) the property is expected to be used on.
     * 
     */
    private $domainIncludes;
    /**
     * Range Includes
     * 
     * @var Class $rangeIncludes Relates a property to a class that constitutes (one of) the expected type(s) for values of the property.
     * 
     */
    private $rangeIncludes;
}
