<?php

namespace SchemaOrg;

/**
 * Rating
 *
 * @link http://schema.org/Rating
 */
class Rating extends Intangible
{
    /**
     * Best Rating (Number)
     *
     * @var float The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.
     */
    protected $bestRatingNumber;
    /**
     * Best Rating (Text)
     *
     * @var string The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.
     */
    protected $bestRatingText;
    /**
     * Rating Value
     *
     * @var string The rating for the content.
     */
    protected $ratingValue;
    /**
     * Worst Rating (Number)
     *
     * @var float The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.
     */
    protected $worstRatingNumber;
    /**
     * Worst Rating (Text)
     *
     * @var string The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.
     */
    protected $worstRatingText;
}
