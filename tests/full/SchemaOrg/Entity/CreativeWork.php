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
     */
    private $about;
    /**
     */
    private $accessibilityAPI;
    /**
     */
    private $accessibilityControl;
    /**
     */
    private $accessibilityFeature;
    /**
     */
    private $accessibilityHazard;
    /**
     */
    private $accountablePerson;
    /**
     */
    private $aggregateRating;
    /**
     */
    private $alternativeHeadline;
    /**
     */
    private $associatedMedia;
    /**
     */
    private $audience;
    /**
     */
    private $audio;
    /**
     */
    private $author;
    /**
     */
    private $award;
    /**
     */
    private $citation;
    /**
     */
    private $comment;
    /**
     */
    private $contentLocation;
    /**
     */
    private $contentRating;
    /**
     */
    private $contributor;
    /**
     */
    private $copyrightHolder;
    /**
     */
    private $copyrightYear;
    /**
     */
    private $creator;
    /**
     */
    private $dateCreated;
    /**
     */
    private $dateModified;
    /**
     */
    private $datePublished;
    /**
     */
    private $discussionUrl;
    /**
     */
    private $editor;
    /**
     */
    private $educationalAlignment;
    /**
     */
    private $educationalUse;
    /**
     */
    private $encoding;
    /**
     */
    private $genre;
    /**
     */
    private $headline;
    /**
     */
    private $inLanguage;
    /**
     */
    private $interactionCount;
    /**
     */
    private $interactivityType;
    /**
     */
    private $isBasedOnUrl;
    /**
     */
    private $isFamilyFriendly;
    /**
     */
    private $isPartOf;
    /**
     */
    private $keywords;
    /**
     */
    private $license;
    /**
     */
    private $learningResourceType;
    /**
     */
    private $mentions;
    /**
     */
    private $offers;
    /**
     */
    private $position;
    /**
     */
    private $publisher;
    /**
     */
    private $publishingPrinciples;
    /**
     */
    private $review;
    /**
     */
    private $sourceOrganization;
    /**
     */
    private $text;
    /**
     */
    private $thumbnailUrl;
    /**
     */
    private $timeRequired;
    /**
     */
    private $typicalAgeRange;
    /**
     */
    private $version;
    /**
     */
    private $video;
    /**
     */
    private $provider;
    /**
     */
    private $commentCount;
    /**
     */
    private $hasPart;
    /**
     */
    private $workExample;
    /**
     */
    private $exampleOfWork;
}
