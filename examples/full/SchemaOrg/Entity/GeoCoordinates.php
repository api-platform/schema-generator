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
     * @type float $elevation The elevation of a location.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $elevation;
    /**
     * @type float $latitude The latitude of a location. For example <code>37.42242</code>.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $latitude;
    /**
     * @type float $longitude The longitude of a location. For example <code>-122.08585</code>.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $longitude;
}
