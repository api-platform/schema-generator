<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Geo Coordinates
 * 
 * @link http://schema.org/GeoCoordinates
 * 
 * @ORM\Entity
 */
class GeoCoordinates extends StructuredValue
{
    /**
     * Elevation
     * 
     * @var string $elevation The elevation of a location.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $elevation;
    /**
     * Latitude
     * 
     * @var float $latitude The latitude of a location. For example 37.42242.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $latitude;
    /**
     * Longitude
     * 
     * @var float $longitude The longitude of a location. For example -122.08585.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $longitude;
}
