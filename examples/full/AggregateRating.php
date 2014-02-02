<?php

namespace SchemaOrg;

/**
 * Aggregate Rating
 *
 * @link http://schema.org/AggregateRating
 */
class AggregateRating extends Rating
{
    /**
     * Item Reviewed
     *
     * @var Thing The item that is being reviewed/rated.
     */
    protected $itemReviewed;
    /**
     * Rating Count
     *
     * @var float The count of total number of ratings.
     */
    protected $ratingCount;
    /**
     * Review Count
     *
     * @var float The count of total number of reviews.
     */
    protected $reviewCount;
}
