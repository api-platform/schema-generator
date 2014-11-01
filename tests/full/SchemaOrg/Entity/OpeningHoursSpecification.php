<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A structured value providing information about the opening hours of a place or a certain service inside a place.
 * 
 * @see http://schema.org/OpeningHoursSpecification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OpeningHoursSpecification extends StructuredValue
{
    /**
     */
    private $closes;
    /**
     */
    private $dayOfWeek;
    /**
     */
    private $opens;
    /**
     */
    private $validFrom;
    /**
     */
    private $validThrough;
}
