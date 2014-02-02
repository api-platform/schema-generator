<?php

namespace SchemaOrg;

/**
 * Geo Coordinates
 *
 * @link http://schema.org/GeoCoordinates
 */
class GeoCoordinates extends StructuredValue
{
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
     * Latitude (Number)
     *
     * @var float The latitude of a location. For example <code>37.42242</code>.
     */
    protected $latitudeNumber;
    /**
     * Latitude (Text)
     *
     * @var string The latitude of a location. For example <code>37.42242</code>.
     */
    protected $latitudeText;
    /**
     * Longitude (Number)
     *
     * @var float The longitude of a location. For example <code>-122.08585</code>.
     */
    protected $longitudeNumber;
    /**
     * Longitude (Text)
     *
     * @var string The longitude of a location. For example <code>-122.08585</code>.
     */
    protected $longitudeText;
}
