<?php

namespace SchemaOrg;

/**
 * Property
 *
 * @link http://schema.org/Property
 */
class Property extends Thing
{
    /**
     * Domain Includes
     *
     * @var Class Relates a property to a class that is (one of) the type(s) the property is expected to be used on.
     */
    protected $domainIncludes;
    /**
     * Range Includes
     *
     * @var Class Relates a property to a class that constitutes (one of) the expected type(s) for values of the property.
     */
    protected $rangeIncludes;
}
