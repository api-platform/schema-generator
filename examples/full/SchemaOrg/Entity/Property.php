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
     * @type Class $domainIncludes Relates a property to a class that is (one of) the type(s) the property is expected to be used on.
     */
    private $domainIncludes;
    /**
     * @type Property $inverseOf Relates a property to a property that is its inverse. Inverse properties relate the same pairs of items to each other, but in reversed direction. For example, the 'alumni' and 'alumniOf' properties are inverseOf each other. Some properties don't have explicit inverses; in these situations RDFa and JSON-LD syntax for reverse properties can be used.
     */
    private $inverseOf;
    /**
     * @type Property $supercededBy Relates a property to one that supercedes it.
     */
    private $supercededBy;
    /**
     * @type Class $rangeIncludes Relates a property to a class that constitutes (one of) the expected type(s) for values of the property.
     */
    private $rangeIncludes;
}
