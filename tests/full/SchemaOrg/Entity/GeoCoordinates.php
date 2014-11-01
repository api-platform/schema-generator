<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The geographic coordinates of a place or event.
 * 
 * @see http://schema.org/GeoCoordinates Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GeoCoordinates extends StructuredValue
{
    /**
     */
    private $elevation;
    /**
     */
    private $latitude;
    /**
     */
    private $longitude;
}
