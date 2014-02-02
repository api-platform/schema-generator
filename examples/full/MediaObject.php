<?php

namespace SchemaOrg;

/**
 * Media Object
 *
 * @link http://schema.org/MediaObject
 */
class MediaObject extends CreativeWork
{
    /**
     * Associated Article
     *
     * @var NewsArticle A NewsArticle associated with the Media Object.
     */
    protected $associatedArticle;
    /**
     * Bitrate
     *
     * @var string The bitrate of the media object.
     */
    protected $bitrate;
    /**
     * Content Size
     *
     * @var string File size in (mega/kilo) bytes.
     */
    protected $contentSize;
    /**
     * Content Url
     *
     * @var string Actual bytes of the media object, for example the image file or video file. (previous spelling: contentURL)
     */
    protected $contentUrl;
    /**
     * Duration
     *
     * @var Duration The duration of the item (movie, audio recording, event, etc.) in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>.
     */
    protected $duration;
    /**
     * Embed Url
     *
     * @var string A URL pointing to a player for a specific video. In general, this is the information in the <code>src</code> element of an <code>embed</code> tag and should not be the same as the content of the <code>loc</code> tag. (previous spelling: embedURL)
     */
    protected $embedUrl;
    /**
     * Encodes Creative Work
     *
     * @var CreativeWork The creative work encoded by this media object
     */
    protected $encodesCreativeWork;
    /**
     * Encoding Format
     *
     * @var string mp3, mpeg4, etc.
     */
    protected $encodingFormat;
    /**
     * Expires
     *
     * @var \DateTime Date the content expires and is no longer useful or available. Useful for videos.
     */
    protected $expires;
    /**
     * Height (Distance)
     *
     * @var Distance The height of the item.
     */
    protected $heightDistance;
    /**
     * Height (QuantitativeValue)
     *
     * @var QuantitativeValue The height of the item.
     */
    protected $heightQuantitativeValue;
    /**
     * Player Type
     *
     * @var string Player type required—for example, Flash or Silverlight.
     */
    protected $playerType;
    /**
     * Production Company
     *
     * @var Organization The production company or studio that made the movie, tv/radio series, season, or episode, or media object.
     */
    protected $productionCompany;
    /**
     * Publication
     *
     * @var PublicationEvent A publication event associated with the episode, clip or media object.
     */
    protected $publication;
    /**
     * Regions Allowed
     *
     * @var Place The regions where the media is allowed. If not specified, then it's assumed to be allowed everywhere. Specify the countries in <a href="http://en.wikipedia.org/wiki/ISO_3166">ISO 3166 format</a>.
     */
    protected $regionsAllowed;
    /**
     * Requires Subscription
     *
     * @var boolean Indicates if use of the media require a subscription  (either paid or free). Allowed values are <code>true</code> or <code>false</code> (note that an earlier version had 'yes', 'no').
     */
    protected $requiresSubscription;
    /**
     * Upload Date
     *
     * @var \DateTime Date when this media object was uploaded to this site.
     */
    protected $uploadDate;
    /**
     * Width (Distance)
     *
     * @var Distance The width of the item.
     */
    protected $widthDistance;
    /**
     * Width (QuantitativeValue)
     *
     * @var QuantitativeValue The width of the item.
     */
    protected $widthQuantitativeValue;
}
