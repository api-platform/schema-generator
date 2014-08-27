<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The geographic shape of a place.
 * 
 * @see http://schema.org/GeoShape Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GeoShape extends StructuredValue
{
    /**
     * @type string $box A polygon is the area enclosed by a point-to-point path for which the starting and ending points are the same. A polygon is expressed as a series of four or more space delimited points where the first and final points are identical.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $box;
    /**
     * @type string $circle A circle is the circular region of a specified radius centered at a specified latitude and longitude. A circle is expressed as a pair followed by a radius in meters.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $circle;
    /**
     * @type float $elevation The elevation of a location.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $elevation;
    /**
     * @type string $line A line is a point-to-point path consisting of two or more points. A line is expressed as a series of two or more point objects separated by space.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $line;
    /**
     * @type string $polygon A polygon is the area enclosed by a point-to-point path for which the starting and ending points are the same. A polygon is expressed as a series of four or more space delimited points where the first and final points are identical.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $polygon;
}
