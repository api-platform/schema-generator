<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An image, video, or audio object embedded in a web page. Note that a creative work may have many media objects associated with it on the same web page. For example, a page about a single song (MusicRecording) may have a music video (VideoObject), and a high and low bandwidth audio stream (2 AudioObject's).
 * 
 * @see http://schema.org/MediaObject Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MediaObject extends CreativeWork
{
    /**
     * @type NewsArticle $associatedArticle A NewsArticle associated with the Media Object.
     * @ORM\ManyToOne(targetEntity="NewsArticle")
     */
    private $associatedArticle;
    /**
     * @type string $bitrate The bitrate of the media object.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $bitrate;
    /**
     * @type string $contentSize File size in (mega/kilo) bytes.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $contentSize;
    /**
     * @type string $contentUrl Actual bytes of the media object, for example the image file or video file. (previous spelling: contentURL)
     * @Assert\Url
     * @ORM\Column
     */
    private $contentUrl;
    /**
     * @type Duration $duration The duration of the item (movie, audio recording, event, etc.) in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;
    /**
     * @type string $embedUrl A URL pointing to a player for a specific video. In general, this is the information in the <code>src</code> element of an <code>embed</code> tag and should not be the same as the content of the <code>loc</code> tag. (previous spelling: embedURL)
     * @Assert\Url
     * @ORM\Column
     */
    private $embedUrl;
    /**
     * @type CreativeWork $encodesCreativeWork The CreativeWork encoded by this media object.
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     * @ORM\JoinColumn(nullable=false)
     */
    private $encodesCreativeWork;
    /**
     * @type string $encodingFormat mp3, mpeg4, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $encodingFormat;
    /**
     * @type \DateTime $expires Date the content expires and is no longer useful or available. Useful for videos.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $expires;
    /**
     * @type Distance $height The height of the item.
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $height;
    /**
     * @type string $interactionCount A count of a specific user interactions with this item&#x2014;for example, <code>20 UserLikes</code>, <code>5 UserComments</code>, or <code>300 UserDownloads</code>. The user interaction type should be one of the sub types of <a href='UserInteraction'>UserInteraction</a>.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactionCount;
    /**
     * @type Offer $offers An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, or give away tickets to an event.
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * @type string $playerType Player type required&#x2014;for example, Flash or Silverlight.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $playerType;
    /**
     * @type Organization $productionCompany The production company or studio that made the movie, tv/radio series, season, or episode, or media object.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionCompany;
    /**
     * @type PublicationEvent $publication A publication event associated with the episode, clip or media object.
     * @ORM\ManyToOne(targetEntity="PublicationEvent")
     */
    private $publication;
    /**
     * @type Place $regionsAllowed The regions where the media is allowed. If not specified, then it's assumed to be allowed everywhere. Specify the countries in <a href='http://en.wikipedia.org/wiki/ISO_3166'>ISO 3166 format</a>.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regionsAllowed;
    /**
     * @type boolean $requiresSubscription Indicates if use of the media require a subscription  (either paid or free). Allowed values are <code>true</code> or <code>false</code> (note that an earlier version had 'yes', 'no').
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $requiresSubscription;
    /**
     * @type \DateTime $uploadDate Date when this media object was uploaded to this site.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $uploadDate;
    /**
     * @type Distance $width The width of the item.
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $width;
}
