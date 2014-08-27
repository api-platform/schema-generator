<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entities that have a somewhat fixed, physical extension.
 * 
 * @see http://schema.org/Place Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Place extends Thing
{
    /**
     * @type PostalAddress $address Physical address of the item.
     */
    private $address;
    /**
     * @type AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * @type Place $containedIn The basic containment relation between places.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $containedIn;
    /**
     * @type Event $event Upcoming or past event associated with this place or organization.
     */
    private $event;
    /**
     * @type string $faxNumber The fax number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $faxNumber;
    /**
     * @type GeoCoordinates $geo The geo coordinates of the place.
     * @ORM\ManyToOne(targetEntity="GeoCoordinates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $geo;
    /**
     * @type string $globalLocationNumber The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $globalLocationNumber;
    /**
     * @type string $interactionCount A count of a specific user interactions with this item&#x2014;for example, <code>20 UserLikes</code>, <code>5 UserComments</code>, or <code>300 UserDownloads</code>. The user interaction type should be one of the sub types of <a href='UserInteraction'>UserInteraction</a>.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactionCount;
    /**
     * @type string $isicV4 The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $isicV4;
    /**
     * @type ImageObject $logo A logo associated with an organization.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $logo;
    /**
     * @type string $hasMap A URL to a map of the place.
     * @Assert\Url
     * @ORM\Column
     */
    private $hasMap;
    /**
     * @type string $map A URL to a map of the place.
     * @Assert\Url
     * @ORM\Column
     */
    private $map;
    /**
     * @type OpeningHoursSpecification $openingHoursSpecification The opening hours of a certain place.
     * @ORM\ManyToOne(targetEntity="OpeningHoursSpecification")
     */
    private $openingHoursSpecification;
    /**
     * @type ImageObject $photo A photograph of this place.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $photo;
    /**
     * @type Review $review A review of the item.
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
    /**
     * @type string $telephone The telephone number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $telephone;
}
