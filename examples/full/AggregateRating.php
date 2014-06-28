<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Aggregate Rating
 * 
 * @link http://schema.org/AggregateRating
 * 
 * @ORM\Entity
 */
class AggregateRating extends Rating
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
     * Rating Count
     * 
     * @var float $ratingCount The count of total number of ratings.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $ratingCount;
    /**
     * Review Count
     * 
     * @var float $reviewCount The count of total number of reviews.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $reviewCount;
}
