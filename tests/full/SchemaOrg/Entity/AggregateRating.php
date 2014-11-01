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
     */
    private $itemReviewed;
    /**
     */
    private $ratingCount;
    /**
     */
    private $reviewCount;
}
