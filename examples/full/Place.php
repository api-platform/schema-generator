<?php

namespace SchemaOrg;

/**
 * Place
 *
 * @link http://schema.org/Place
 */
class Place extends Thing
{
    /**
     * Address
     *
     * @var PostalAddress Physical address of the item.
     */
    protected $address;
    /**
     * Aggregate Rating
     *
     * @var AggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     */
    protected $aggregateRating;
    /**
     * Contained in
     *
     * @var Place The basic containment relation between places.
     */
    protected $containedIn;
    /**
     * Event
     *
     * @var Event Upcoming or past event associated with this place or organization.
     */
    protected $event;
    /**
     * Fax Number
     *
     * @var string The fax number.
     */
    protected $faxNumber;
    /**
     * Geo (GeoCoordinates)
     *
     * @var GeoCoordinates The geo coordinates of the place.
     */
    protected $geoGeoCoordinates;
    /**
     * Geo (GeoShape)
     *
     * @var GeoShape The geo coordinates of the place.
     */
    protected $geoGeoShape;
    /**
     * Global Location Number
     *
     * @var string The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.
     */
    protected $globalLocationNumber;
    /**
     * Interaction Count
     *
     * @var string A count of a specific user interactions with this item—for example, <code>20 UserLikes</code>, <code>5 UserComments</code>, or <code>300 UserDownloads</code>. The user interaction type should be one of the sub types of <a href="http://schema.org/UserInteraction">UserInteraction</a>.
     */
    protected $interactionCount;
    /**
     * Isic V4
     *
     * @var string The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.
     */
    protected $isicV4;
    /**
     * Logo (URL)
     *
     * @var string A logo associated with an organization.
     */
    protected $logoURL;
    /**
     * Logo (ImageObject)
     *
     * @var ImageObject A logo associated with an organization.
     */
    protected $logoImageObject;
    /**
     * Map
     *
     * @var string A URL to a map of the place.
     */
    protected $map;
    /**
     * Opening Hours Specification
     *
     * @var OpeningHoursSpecification The opening hours of a certain place.
     */
    protected $openingHoursSpecification;
    /**
     * Photo (ImageObject)
     *
     * @var ImageObject A photograph of this place.
     */
    protected $photoImageObject;
    /**
     * Photo (Photograph)
     *
     * @var Photograph A photograph of this place.
     */
    protected $photoPhotograph;
    /**
     * Review
     *
     * @var Review A review of the item.
     */
    protected $review;
    /**
     * Telephone
     *
     * @var string The telephone number.
     */
    protected $telephone;
}
