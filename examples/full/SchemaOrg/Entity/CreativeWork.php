<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The most generic kind of creative work, including books, movies, photographs, software programs, etc.
 * 
 * @see http://schema.org/CreativeWork Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CreativeWork extends Thing
{
    /**
     * @type Thing $about The subject matter of the content.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $about;
    /**
     * @type string $accessibilityAPI Indicates that the resource is compatible with the referenced accessibility API (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>).
         
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityAPI;
    /**
     * @type string $accessibilityControl Identifies input methods that are sufficient to fully control the described resource (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityControl;
    /**
     * @type string $accessibilityFeature Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityFeature;
    /**
     * @type string $accessibilityHazard A characteristic of the described resource that is physiologically dangerous to some users. Related to WCAG 2.0 guideline 2.3. (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>)
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessibilityHazard;
    /**
     * @type Person $accountablePerson Specifies the Person that is legally accountable for the CreativeWork.
     */
    private $accountablePerson;
    /**
     * @type AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * @type string $alternativeHeadline A secondary title of the CreativeWork.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alternativeHeadline;
    /**
     * @type MediaObject $associatedMedia A media object that encodes this CreativeWork. This property is a synonym for encoding.
     * @ORM\ManyToOne(targetEntity="MediaObject")
     */
    private $associatedMedia;
    /**
     * @type Audience $audience The intended audience of the item, i.e. the group for whom the item was created.
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $audience;
    /**
     * @type AudioObject $audio An embedded audio object.
     * @ORM\ManyToOne(targetEntity="AudioObject")
     */
    private $audio;
    /**
     * @type Organization $author The author of this content. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;
    /**
     * @type string $award An award won by this person or for this creative work.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $award;
    /**
     * @type CreativeWork $citation A citation or reference to another creative work, such as another publication, web page, scholarly article, etc.
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     */
    private $citation;
    /**
     * @type UserComments $comment Comments, typically from users, on this CreativeWork.
     */
    private $comment;
    /**
     * @type Place $contentLocation The location of the content.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contentLocation;
    /**
     * @type string $contentRating Official rating of a piece of content&#x2014;for example,'MPAA PG-13'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $contentRating;
    /**
     * @type Organization $contributor A secondary contributor to the CreativeWork.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $contributor;
    /**
     * @type Organization $copyrightHolder The party holding the legal copyright to the CreativeWork.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $copyrightHolder;
    /**
     * @type float $copyrightYear The year during which the claimed copyright for the CreativeWork was first asserted.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $copyrightYear;
    /**
     * @type Organization $creator The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;
    /**
     * @type \DateTime $dateCreated The date on which the CreativeWork was created.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $dateCreated;
    /**
     * @type \DateTime $dateModified The date on which the CreativeWork was most recently modified.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $dateModified;
    /**
     * @type \DateTime $datePublished Date of first broadcast/publication.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $datePublished;
    /**
     * @type string $discussionUrl A link to the page containing the comments of the CreativeWork.
     * @Assert\Url
     * @ORM\Column
     */
    private $discussionUrl;
    /**
     * @type Person $editor Specifies the Person who edited the CreativeWork.
     */
    private $editor;
    /**
     * @type AlignmentObject $educationalAlignment An alignment to an established educational framework.
     * @ORM\ManyToOne(targetEntity="AlignmentObject")
     */
    private $educationalAlignment;
    /**
     * @type string $educationalUse The purpose of a work in the context of education; for example, 'assignment', 'group work'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationalUse;
    /**
     * @type MediaObject $encoding A media object that encodes this CreativeWork. This property is a synonym for associatedMedia.
     * @ORM\ManyToOne(targetEntity="MediaObject")
     */
    private $encoding;
    /**
     * @type string $genre Genre of the creative work
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $genre;
    /**
     * @type string $headline Headline of the article
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $headline;
    /**
     * @type string $inLanguage The language of the content. please use one of the language codes from the <a href='http://tools.ietf.org/html/bcp47'>IETF BCP 47 standard.</a>
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $inLanguage;
    /**
     * @type string $interactionCount A count of a specific user interactions with this item&#x2014;for example, <code>20 UserLikes</code>, <code>5 UserComments</code>, or <code>300 UserDownloads</code>. The user interaction type should be one of the sub types of <a href='UserInteraction'>UserInteraction</a>.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactionCount;
    /**
     * @type string $interactivityType The predominant mode of learning supported by the learning resource. Acceptable values are 'active', 'expositive', or 'mixed'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $interactivityType;
    /**
     * @type string $isBasedOnUrl A resource that was used in the creation of this resource. This term can be repeated for multiple sources. For example, http://example.com/great-multiplication-intro.html
     * @Assert\Url
     * @ORM\Column
     */
    private $isBasedOnUrl;
    /**
     * @type boolean $isFamilyFriendly Indicates whether this content is family friendly.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isFamilyFriendly;
    /**
     * @type CreativeWork $isPartOf Indicates a CreativeWork that this CreativeWork is (in some sense) part of.
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     * @ORM\JoinColumn(nullable=false)
     */
    private $isPartOf;
    /**
     * @type string $keywords Keywords or tags used to describe this content. Multiple entries in a keywords list are typically delimited by commas.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $keywords;
    /**
     * @type CreativeWork $license A license document that applies to this content, typically indicated by URL.
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     */
    private $license;
    /**
     * @type string $learningResourceType The predominant type or kind characterizing the learning resource. For example, 'presentation', 'handout'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $learningResourceType;
    /**
     * @type Thing $mentions Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.
     */
    private $mentions;
    /**
     * @type Offer $offers An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, or give away tickets to an event.
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * @type string $position The position of the creative work within a series or other ordered collection of works.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $position;
    /**
     * @type Organization $publisher The publisher of the creative work.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $publisher;
    /**
     * @type string $publishingPrinciples Link to page describing the editorial principles of the organization primarily responsible for the creation of the CreativeWork.
     * @Assert\Url
     * @ORM\Column
     */
    private $publishingPrinciples;
    /**
     * @type Review $review A review of the item.
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
    /**
     * @type Organization $sourceOrganization The Organization on whose behalf the creator was working.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sourceOrganization;
    /**
     * @type string $text The textual content of this CreativeWork.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $text;
    /**
     * @type string $thumbnailUrl A thumbnail image relevant to the Thing.
     * @Assert\Url
     * @ORM\Column
     */
    private $thumbnailUrl;
    /**
     * @type Duration $timeRequired Approximate or typical time it takes to work with or through this learning resource for the typical intended target audience, e.g. 'P30M', 'P1H25M'.
     */
    private $timeRequired;
    /**
     * @type string $typicalAgeRange The typical expected age range, e.g. '7-9', '11-'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $typicalAgeRange;
    /**
     * @type float $version The version of the CreativeWork embodied by a specified resource.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $version;
    /**
     * @type VideoObject $video An embedded video object.
     * @ORM\ManyToOne(targetEntity="VideoObject")
     */
    private $video;
    /**
     * @type Person $provider The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $provider;
    /**
     * @type integer $commentCount The number of comments this CreativeWork (e.g. Article, Question or Answer) has received. This is most applicable to works published in Web sites with commenting system; additional comments may exist elsewhere.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $commentCount;
    /**
     * @type CreativeWork $hasPart Indicates a CreativeWork that is (in some sense) a part of this CreativeWork.
     */
    private $hasPart;
    /**
     * @type CreativeWork $workExample Example/instance/realization/derivation of the concept of this creative work. eg. The paperback edition, first edition, or eBook.
     */
    private $workExample;
    /**
     * @type CreativeWork $exampleOfWork A creative work that this work is an example/instance/realization/derivation of.
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     */
    private $exampleOfWork;
}
