<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * An enumeration of several kinds of Map.
 * 
 * @see http://schema.org/MapCategoryType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MapCategoryType extends Enum
{
    /**
     * @type string PARKING_MAP A parking map.
    */
    const PARKING_MAP = 'http://schema.org/ParkingMap';
    /**
     * @type string SEATING_MAP A seating map.
    */
    const SEATING_MAP = 'http://schema.org/SeatingMap';
    /**
     * @type string VENUE_MAP A venue map (e.g. for malls, auditoriums, museums, etc.).
    */
    const VENUE_MAP = 'http://schema.org/VenueMap';
    /**
     * @type string TRANSIT_MAP A transit map.
    */
    const TRANSIT_MAP = 'http://schema.org/TransitMap';
}
