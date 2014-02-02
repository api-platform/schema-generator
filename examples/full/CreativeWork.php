<?php

namespace SchemaOrg;

/**
 * Creative Work
 *
 * @link http://schema.org/CreativeWork
 */
class CreativeWork extends Thing
{
    /**
     * About
     *
     * @var Thing The subject matter of the content.
     */
    protected $about;
    /**
     * Accessibility API
     *
     * @var string Indicates that the resource is compatible with the referenced accessibility API (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>).

     */
    protected $accessibilityAPI;
    /**
     * Accessibility Control
     *
     * @var string Identifies input methods that are sufficient to fully control the described resource (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>).
     */
    protected $accessibilityControl;
    /**
     * Accessibility Feature
     *
     * @var string Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>).
     */
    protected $accessibilityFeature;
    /**
     * Accessibility Hazard
     *
     * @var string A characteristic of the described resource that is physiologically dangerous to some users. Related to WCAG 2.0 guideline 2.3. (<a href="http://www.w3.org/wiki/WebSchemas/Accessibility">WebSchemas wiki lists possible values</a>)
     */
    protected $accessibilityHazard;
    /**
     * Accountable Person
     *
     * @var Person Specifies the Person that is legally accountable for the CreativeWork.
     */
    protected $accountablePerson;
    /**
     * Aggregate Rating
     *
     * @var AggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     */
    protected $aggregateRating;
    /**
     * Alternative Headline
     *
     * @var string A secondary title of the CreativeWork.
     */
    protected $alternativeHeadline;
    /**
     * Associated Media
     *
     * @var MediaObject The media objects that encode this creative work. This property is a synonym for encodings.
     */
    protected $associatedMedia;
    /**
     * Audience
     *
     * @var Audience The intended audience of the item, i.e. the group for whom the item was created.
     */
    protected $audience;
    /**
     * Audio
     *
     * @var AudioObject An embedded audio object.
     */
    protected $audio;
    /**
     * Author (Organization)
     *
     * @var Organization The author of this content. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     */
    protected $authorOrganization;
    /**
     * Author (Person)
     *
     * @var Person The author of this content. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     */
    protected $authorPerson;
    /**
     * Award
     *
     * @var string An award won by this person or for this creative work.
     */
    protected $award;
    /**
     * Citation (CreativeWork)
     *
     * @var CreativeWork A citation or reference to another creative work, such as another publication, web page, scholarly article, etc. NOTE: Candidate for promotion to ScholarlyArticle.
     */
    protected $citationCreativeWork;
    /**
     * Citation (Text)
     *
     * @var string A citation or reference to another creative work, such as another publication, web page, scholarly article, etc. NOTE: Candidate for promotion to ScholarlyArticle.
     */
    protected $citationText;
    /**
     * Comment
     *
     * @var UserComments Comments, typically from users, on this CreativeWork.
     */
    protected $comment;
    /**
     * Content Location
     *
     * @var Place The location of the content.
     */
    protected $contentLocation;
    /**
     * Content Rating
     *
     * @var string Official rating of a piece of content—for example,'MPAA PG-13'.
     */
    protected $contentRating;
    /**
     * Contributor (Organization)
     *
     * @var Organization A secondary contributor to the CreativeWork.
     */
    protected $contributorOrganization;
    /**
     * Contributor (Person)
     *
     * @var Person A secondary contributor to the CreativeWork.
     */
    protected $contributorPerson;
    /**
     * Copyright Holder (Organization)
     *
     * @var Organization The party holding the legal copyright to the CreativeWork.
     */
    protected $copyrightHolderOrganization;
    /**
     * Copyright Holder (Person)
     *
     * @var Person The party holding the legal copyright to the CreativeWork.
     */
    protected $copyrightHolderPerson;
    /**
     * Copyright Year
     *
     * @var float The year during which the claimed copyright for the CreativeWork was first asserted.
     */
    protected $copyrightYear;
    /**
     * Creator (Organization)
     *
     * @var Organization The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     */
    protected $creatorOrganization;
    /**
     * Creator (Person)
     *
     * @var Person The creator/author of this CreativeWork or UserComments. This is the same as the Author property for CreativeWork.
     */
    protected $creatorPerson;
    /**
     * Date Created
     *
     * @var \DateTime The date on which the CreativeWork was created.
     */
    protected $dateCreated;
    /**
     * Date Modified
     *
     * @var \DateTime The date on which the CreativeWork was most recently modified.
     */
    protected $dateModified;
    /**
     * Date Published
     *
     * @var \DateTime Date of first broadcast/publication.
     */
    protected $datePublished;
    /**
     * Discussion Url
     *
     * @var string A link to the page containing the comments of the CreativeWork.
     */
    protected $discussionUrl;
    /**
     * Editor
     *
     * @var Person Specifies the Person who edited the CreativeWork.
     */
    protected $editor;
    /**
     * Educational Alignment
     *
     * @var AlignmentObject An alignment to an established educational framework.
     */
    protected $educationalAlignment;
    /**
     * Educational Use
     *
     * @var string The purpose of a work in the context of education; for example, 'assignment', 'group work'.
     */
    protected $educationalUse;
    /**
     * Encoding
     *
     * @var MediaObject A media object that encode this CreativeWork.
     */
    protected $encoding;
    /**
     * Genre
     *
     * @var string Genre of the creative work
     */
    protected $genre;
    /**
     * Headline
     *
     * @var string Headline of the article
     */
    protected $headline;
    /**
     * In Language
     *
     * @var string The language of the content. please use one of the language codes from the <a href="http://tools.ietf.org/html/bcp47">IETF BCP 47 standard.</a>
     */
    protected $inLanguage;
    /**
     * Interaction Count
     *
     * @var string A count of a specific user interactions with this item—for example, <code>20 UserLikes</code>, <code>5 UserComments</code>, or <code>300 UserDownloads</code>. The user interaction type should be one of the sub types of <a href="http://schema.org/UserInteraction">UserInteraction</a>.
     */
    protected $interactionCount;
    /**
     * Interactivity Type
     *
     * @var string The predominant mode of learning supported by the learning resource. Acceptable values are 'active', 'expositive', or 'mixed'.
     */
    protected $interactivityType;
    /**
     * Is Based On Url
     *
     * @var string A resource that was used in the creation of this resource. This term can be repeated for multiple sources. For example, http://example.com/great-multiplication-intro.html
     */
    protected $isBasedOnUrl;
    /**
     * Is Family Friendly
     *
     * @var boolean Indicates whether this content is family friendly.
     */
    protected $isFamilyFriendly;
    /**
     * Keywords
     *
     * @var string The keywords/tags used to describe this content.
     */
    protected $keywords;
    /**
     * Learning Resource Type
     *
     * @var string The predominant type or kind characterizing the learning resource. For example, 'presentation', 'handout'.
     */
    protected $learningResourceType;
    /**
     * Mentions
     *
     * @var Thing Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.
     */
    protected $mentions;
    /**
     * Offers
     *
     * @var Offer An offer to sell this item—for example, an offer to sell a product, the DVD of a movie, or tickets to an event.
     */
    protected $offers;
    /**
     * Provider (Organization)
     *
     * @var Organization The organization or agency that is providing the service.
     */
    protected $providerOrganization;
    /**
     * Provider (Person)
     *
     * @var Person The organization or agency that is providing the service.
     */
    protected $providerPerson;
    /**
     * Publisher
     *
     * @var Organization The publisher of the creative work.
     */
    protected $publisher;
    /**
     * Publishing Principles
     *
     * @var string Link to page describing the editorial principles of the organization primarily responsible for the creation of the CreativeWork.
     */
    protected $publishingPrinciples;
    /**
     * Review
     *
     * @var Review A review of the item.
     */
    protected $review;
    /**
     * Source Organization
     *
     * @var Organization The Organization on whose behalf the creator was working.
     */
    protected $sourceOrganization;
    /**
     * Text
     *
     * @var string The textual content of this CreativeWork.
     */
    protected $text;
    /**
     * Thumbnail Url
     *
     * @var string A thumbnail image relevant to the Thing.
     */
    protected $thumbnailUrl;
    /**
     * Time Required
     *
     * @var Duration Approximate or typical time it takes to work with or through this learning resource for the typical intended target audience, e.g. 'P30M', 'P1H25M'.
     */
    protected $timeRequired;
    /**
     * Typical Age Range
     *
     * @var string The typical expected age range, e.g. '7-9', '11-'.
     */
    protected $typicalAgeRange;
    /**
     * Version
     *
     * @var float The version of the CreativeWork embodied by a specified resource.
     */
    protected $version;
    /**
     * Video
     *
     * @var VideoObject An embedded video object.
     */
    protected $video;
}
