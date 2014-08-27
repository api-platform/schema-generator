<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The average rating based on multiple ratings or reviews.
 * 
 * @see http://schema.org/AggregateRating Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AggregateRating extends Rating
{
    /**
     * @type Thing $itemReviewed The item that is being reviewed/rated.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemReviewed;
    /**
     * @type float $ratingCount The count of total number of ratings.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $ratingCount;
    /**
     * @type float $reviewCount The count of total number of reviews.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $reviewCount;
}
