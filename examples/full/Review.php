<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 * 
 * @link http://schema.org/Review
 * 
 * @ORM\Entity
 */
class Review extends CreativeWork
{
    /**
     * Item Reviewed
     * 
     * @var Thing $itemReviewed The item that is being reviewed/rated.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemReviewed;
    /**
     * Review Body
     * 
     * @var string $reviewBody The actual body of the review
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $reviewBody;
    /**
     * Review Rating
     * 
     * @var Rating $reviewRating The rating given in this review. Note that reviews can themselves be rated. The reviewRating applies to rating given by the review. The aggregateRating property applies to the review itself, as a creative work.
     * 
     * @ORM\ManyToOne(targetEntity="Rating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reviewRating;
}
