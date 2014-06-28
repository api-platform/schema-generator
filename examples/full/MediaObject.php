<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Media Object
 * 
 * @link http://schema.org/MediaObject
 * 
 * @ORM\MappedSuperclass
 */
class MediaObject extends CreativeWork
{
    /**
     * Associated Article
     * 
     * @var NewsArticle $associatedArticle A NewsArticle associated with the Media Object.
     * 
     * @ORM\ManyToOne(targetEntity="NewsArticle")
     */
    private $associatedArticle;
    /**
     * Bitrate
     * 
     * @var string $bitrate The bitrate of the media object.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $bitrate;
    /**
     * Content Size
     * 
     * @var string $contentSize File size in (mega/kilo) bytes.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $contentSize;
    /**
     * Content Url
     * 
     * @var string $contentUrl Actual bytes of the media object, for example the image file or video file. (previous spelling: contentURL)
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $contentUrl;
    /**
     * Duration
     * 
     * @var Duration $duration The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;
    /**
     * Embed Url
     * 
     * @var string $embedUrl A URL pointing to a player for a specific video. In general, this is the information in the src element of an embed tag and should not be the same as the content of the loc tag. (previous spelling: embedURL)
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $embedUrl;
    /**
     * Encodes Creative Work
     * 
     * @var CreativeWork $encodesCreativeWork The creative work encoded by this media object
     * 
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     * @ORM\JoinColumn(nullable=false)
     */
    private $encodesCreativeWork;
    /**
     * Encoding Format
     * 
     * @var string $encodingFormat mp3, mpeg4, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $encodingFormat;
    /**
     * Expires
     * 
     * @var \DateTime $expires Date the content expires and is no longer useful or available. Useful for videos.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $expires;
    /**
     * Height
     * 
     * @var Distance $height The height of the item.
     * 
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $height;
    /**
     * Player Type
     * 
     * @var string $playerType Player type required—for example, Flash or Silverlight.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $playerType;
    /**
     * Production Company
     * 
     * @var Organization $productionCompany The production company or studio that made the movie, tv/radio series, season, or episode, or media object.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionCompany;
    /**
     * Publication
     * 
     * @var PublicationEvent $publication A publication event associated with the episode, clip or media object.
     * 
     * @ORM\ManyToOne(targetEntity="PublicationEvent")
     */
    private $publication;
    /**
     * Regions Allowed
     * 
     * @var Place $regionsAllowed The regions where the media is allowed. If not specified, then it's assumed to be allowed everywhere. Specify the countries in ISO 3166 format.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regionsAllowed;
    /**
     * Requires Subscription
     * 
     * @var boolean $requiresSubscription Indicates if use of the media require a subscription  (either paid or free). Allowed values are true or false (note that an earlier version had 'yes', 'no').
     * 
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $requiresSubscription;
    /**
     * Upload Date
     * 
     * @var \DateTime $uploadDate Date when this media object was uploaded to this site.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $uploadDate;
    /**
     * Width
     * 
     * @var Distance $width The width of the item.
     * 
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $width;
}
