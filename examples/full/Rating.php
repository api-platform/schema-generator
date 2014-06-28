<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 * 
 * @link http://schema.org/Rating
 * 
 * @ORM\MappedSuperclass
 */
class Rating extends Intangible
{
    /**
     * Best Rating
     * 
     * @var float $bestRating The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $bestRating;
    /**
     * Rating Value
     * 
     * @var string $ratingValue The rating for the content.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $ratingValue;
    /**
     * Worst Rating
     * 
     * @var float $worstRating The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $worstRating;
}
