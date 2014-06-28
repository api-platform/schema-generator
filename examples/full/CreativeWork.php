<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Creative Work
 * 
 * @link http://schema.org/CreativeWork
 * 
 * @ORM\MappedSuperclass
 */
class CreativeWork extends Thing
{
    /**
     * About
     * 
     * @var Thing $about The subject matter of the content.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $about;
    /**
     * Accessibility API
     * 
     * @var string $accessibilityAPI Indicates that the resource is compatible with the referenced accessibility API (WebSchemas wiki lists possible values).
     
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityAPI;
    /**
     * Accessibility Control
     * 
     * @var string $accessibilityControl Identifies input methods that are sufficient to fully control the described resource (WebSchemas wiki lists possible values).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityControl;
    /**
     * Accessibility Feature
     * 
     * @var string $accessibilityFeature Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility (WebSchemas wiki lists possible values).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityFeature;
    /**
     * Accessibility Hazard
     * 
     * @var string $accessibilityHazard A characteristic of the described resource that is physiologically dangerous to some users. Related to WCAG 2.0 guideline 2.3. (WebSchemas wiki lists possible values)
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityHazard;
    /**
     * Accountable Person
     * 
     * @var Person $accountablePerson Specifies the Person that is legally accountable for the CreativeWork.
     * 
     */
    private $accountablePerson;
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
     * Alternative Headline
     * 
     * @var string $alternativeHeadline A secondary title of the CreativeWork.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alternativeHeadline;
    /**
     * Associated Media
     * 
     * @var MediaObject $associatedMedia The media objects that encode this creative work. This property is a synonym for encodings.
     * 
     * @ORM\ManyToOne(targetEntity="MediaObject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $associatedMedia;
    /**
     * Audience
     * 
     * @var Audience $audience The intended audience of the item, i.e. the group for whom the item was created.
     * 
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $audience;
    /**
     * Audio
     * 
     * @var AudioObject $audio An embedded audio object.
     * 
     * @ORM\ManyToOne(targetEntity="AudioObject")
     */
    private $audio;
    /**
     * Author
     * 
     * @var Organization $author The author of this content. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;
    /**
     * Award
     * 
     * @var string $award An award won by this person or for this creative work.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $award;
    /**
     * Citation
     * 
     * @var CreativeWork $citation A citation or reference to another creative work, such as another publication, web page, scholarly article, etc.
     * 
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     */
    private $citation;
    /**
     * Comment
     * 
     * @var UserComments $comment Comments, typically from users, on this CreativeWork.
     * 
     */
    private $comment;
    /**
     * Content Location
     * 
     * @var Place $contentLocation The location of the content.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contentLocation;
    /**
     * Content Rating
     * 
     * @var string $contentRating Official rating of a piece of content—for example,'MPAA PG-13'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $contentRating;
    /**
     * Contributor
     * 
     * @var Organization $contributor A secondary contributor to the CreativeWork.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $contributor;
    /**
     * Copyright Holder
     * 
     * @var Organization $copyrightHolder The party holding the legal copyright to the CreativeWork.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $copyrightHolder;
    /**
     * Copyright Year
     * 
     * @var float $copyrightYear The year during which the claimed copyright for the CreativeWork was first asserted.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $copyrightYear;
    /**
     * Creator
     * 
     * @var Organization $creator The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;
    /**
     * Date Created
     * 
     * @var \DateTime $dateCreated The date on which the CreativeWork was created.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $dateCreated;
    /**
     * Date Modified
     * 
     * @var \DateTime $dateModified The date on which the CreativeWork was most recently modified.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $dateModified;
    /**
     * Date Published
     * 
     * @var \DateTime $datePublished Date of first broadcast/publication.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $datePublished;
    /**
     * Discussion Url
     * 
     * @var string $discussionUrl A link to the page containing the comments of the CreativeWork.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $discussionUrl;
    /**
     * Editor
     * 
     * @var Person $editor Specifies the Person who edited the CreativeWork.
     * 
     */
    private $editor;
    /**
     * Educational Alignment
     * 
     * @var AlignmentObject $educationalAlignment An alignment to an established educational framework.
     * 
     * @ORM\ManyToOne(targetEntity="AlignmentObject")
     */
    private $educationalAlignment;
    /**
     * Educational Use
     * 
     * @var string $educationalUse The purpose of a work in the context of education; for example, 'assignment', 'group work'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationalUse;
    /**
     * Encoding
     * 
     * @var MediaObject $encoding A media object that encode this CreativeWork.
     * 
     * @ORM\ManyToOne(targetEntity="MediaObject")
     */
    private $encoding;
    /**
     * Genre
     * 
     * @var string $genre Genre of the creative work
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $genre;
    /**
     * Headline
     * 
     * @var string $headline Headline of the article
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $headline;
    /**
     * In Language
     * 
     * @var string $inLanguage The language of the content. please use one of the language codes from the IETF BCP 47 standard.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $inLanguage;
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
     * Interactivity Type
     * 
     * @var string $interactivityType The predominant mode of learning supported by the learning resource. Acceptable values are 'active', 'expositive', or 'mixed'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactivityType;
    /**
     * Is Based On Url
     * 
     * @var string $isBasedOnUrl A resource that was used in the creation of this resource. This term can be repeated for multiple sources. For example, http://example.com/great-multiplication-intro.html
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $isBasedOnUrl;
    /**
     * Is Family Friendly
     * 
     * @var boolean $isFamilyFriendly Indicates whether this content is family friendly.
     * 
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isFamilyFriendly;
    /**
     * Keywords
     * 
     * @var string $keywords The keywords/tags used to describe this content.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $keywords;
    /**
     * Learning Resource Type
     * 
     * @var string $learningResourceType The predominant type or kind characterizing the learning resource. For example, 'presentation', 'handout'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $learningResourceType;
    /**
     * Mentions
     * 
     * @var Thing $mentions Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.
     * 
     */
    private $mentions;
    /**
     * Offers
     * 
     * @var Offer $offers An offer to transfer some rights to an item or to provide a service—for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
     * 
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * Provider
     * 
     * @var Organization $provider The organization or agency that is providing the service.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;
    /**
     * Publisher
     * 
     * @var Organization $publisher The publisher of the creative work.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $publisher;
    /**
     * Publishing Principles
     * 
     * @var string $publishingPrinciples Link to page describing the editorial principles of the organization primarily responsible for the creation of the CreativeWork.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $publishingPrinciples;
    /**
     * Review
     * 
     * @var Review $review A review of the item.
     * 
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
    /**
     * Source Organization
     * 
     * @var Organization $sourceOrganization The Organization on whose behalf the creator was working.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sourceOrganization;
    /**
     * Text
     * 
     * @var string $text The textual content of this CreativeWork.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $text;
    /**
     * Thumbnail Url
     * 
     * @var string $thumbnailUrl A thumbnail image relevant to the Thing.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $thumbnailUrl;
    /**
     * Time Required
     * 
     * @var Duration $timeRequired Approximate or typical time it takes to work with or through this learning resource for the typical intended target audience, e.g. 'P30M', 'P1H25M'.
     * 
     */
    private $timeRequired;
    /**
     * Typical Age Range
     * 
     * @var string $typicalAgeRange The typical expected age range, e.g. '7-9', '11-'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $typicalAgeRange;
    /**
     * Version
     * 
     * @var float $version The version of the CreativeWork embodied by a specified resource.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $version;
    /**
     * Video
     * 
     * @var VideoObject $video An embedded video object.
     * 
     * @ORM\ManyToOne(targetEntity="VideoObject")
     */
    private $video;
}
