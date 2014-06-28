<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Place
 * 
 * @link http://schema.org/Place
 * 
 * @ORM\MappedSuperclass
 */
class Place extends Thing
{
    /**
     * Address
     * 
     * @var PostalAddress $address Physical address of the item.
     * 
     */
    private $address;
    /**
     * Aggregate Rating
     * 
     * @var AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * 
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * Contained in
     * 
     * @var Place $containedIn The basic containment relation between places.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $containedIn;
    /**
     * Event
     * 
     * @var Event $event Upcoming or past event associated with this place or organization.
     * 
     */
    private $event;
    /**
     * Fax Number
     * 
     * @var string $faxNumber The fax number.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $faxNumber;
    /**
     * Geo
     * 
     * @var GeoCoordinates $geo The geo coordinates of the place.
     * 
     * @ORM\ManyToOne(targetEntity="GeoCoordinates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $geo;
    /**
     * Global Location Number
     * 
     * @var string $globalLocationNumber The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $globalLocationNumber;
    /**
     * Interaction Count
     * 
     * @var string $interactionCount A count of a specific user interactions with this item—for example, 20 UserLikes, 5 UserComments, or 300 UserDownloads. The user interaction type should be one of the sub types of UserInteraction.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactionCount;
    /**
     * Isic V4
     * 
     * @var string $isicV4 The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $isicV4;
    /**
     * Logo
     * 
     * @var string $logo A logo associated with an organization.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $logo;
    /**
     * Map
     * 
     * @var string $map A URL to a map of the place.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $map;
    /**
     * Opening Hours Specification
     * 
     * @var OpeningHoursSpecification $openingHoursSpecification The opening hours of a certain place.
     * 
     * @ORM\ManyToOne(targetEntity="OpeningHoursSpecification")
     */
    private $openingHoursSpecification;
    /**
     * Photo
     * 
     * @var ImageObject $photo A photograph of this place.
     * 
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $photo;
    /**
     * Review
     * 
     * @var Review $review A review of the item.
     * 
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
    /**
     * Telephone
     * 
     * @var string $telephone The telephone number.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $telephone;
}
