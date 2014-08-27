<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A review of an item - for example, of a restaurant, movie, or store.
 * 
 * @see http://schema.org/Review Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Review extends CreativeWork
{
    /**
     * @type Thing $itemReviewed The item that is being reviewed/rated.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemReviewed;
    /**
     * @type string $reviewBody The actual body of the review.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $reviewBody;
    /**
     * @type Rating $reviewRating The rating given in this review. Note that reviews can themselves be rated. The <code>reviewRating</code> applies to rating given by the review. The <code>aggregateRating</code> property applies to the review itself, as a creative work.
     * @ORM\ManyToOne(targetEntity="Rating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reviewRating;
}
