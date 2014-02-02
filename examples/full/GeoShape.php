<?php

namespace SchemaOrg;

/**
 * Geo Shape
 *
 * @link http://schema.org/GeoShape
 */
class GeoShape extends StructuredValue
{
    /**
     * Box
     *
     * @var string A polygon is the area enclosed by a point-to-point path for which the starting and ending points are the same. A polygon is expressed as a series of four or more spacedelimited points where the first and final points are identical.
     */
    protected $box;
    /**
     * Circle
     *
     * @var string A circle is the circular region of a specified radius centered at a specified latitude and longitude. A circle is expressed as a pair followed by a radius in meters.
     */
    protected $circle;
    /**
     * Elevation (Text)
     *
     * @var string The elevation of a location.
     */
    protected $elevationText;
    /**
     * Elevation (Number)
     *
     * @var float The elevation of a location.
     */
    protected $elevationNumber;
    /**
     * Line
     *
     * @var string A line is a point-to-point path consisting of two or more points. A line is expressed as a series of two or more point objects separated by space.
     */
    protected $line;
    /**
     * Polygon
     *
     * @var string A polygon is the area enclosed by a point-to-point path for which the starting and ending points are the same. A polygon is expressed as a series of four or more spacedelimited points where the first and final points are identical.
     */
    protected $polygon;
}
