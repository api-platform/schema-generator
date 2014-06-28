<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Geo Shape
 * 
 * @link http://schema.org/GeoShape
 * 
 * @ORM\Entity
 */
class GeoShape extends StructuredValue
{
    /**
     * Box
     * 
     * @var string $box A polygon is the area enclosed by a point-to-point path for which the starting and ending points are the same. A polygon is expressed as a series of four or more spacedelimited points where the first and final points are identical.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $box;
    /**
     * Circle
     * 
     * @var string $circle A circle is the circular region of a specified radius centered at a specified latitude and longitude. A circle is expressed as a pair followed by a radius in meters.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $circle;
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
     * Line
     * 
     * @var string $line A line is a point-to-point path consisting of two or more points. A line is expressed as a series of two or more point objects separated by space.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $line;
    /**
     * Polygon
     * 
     * @var string $polygon A polygon is the area enclosed by a point-to-point path for which the starting and ending points are the same. A polygon is expressed as a series of four or more spacedelimited points where the first and final points are identical.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $polygon;
}
