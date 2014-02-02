<?php

namespace SchemaOrg;

/**
 * Review
 *
 * @link http://schema.org/Review
 */
class Review extends CreativeWork
{
    /**
     * Item Reviewed
     *
     * @var Thing The item that is being reviewed/rated.
     */
    protected $itemReviewed;
    /**
     * Review Body
     *
     * @var string The actual body of the review
     */
    protected $reviewBody;
    /**
     * Review Rating
     *
     * @var Rating The rating given in this review. Note that reviews can themselves be rated. The <code>reviewRating</code> applies to rating given by the review. The <code>aggregateRating</code> property applies to the review itself, as a creative work.
     */
    protected $reviewRating;
}
