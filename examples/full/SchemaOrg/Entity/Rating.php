<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The rating of the video.
 * 
 * @see http://schema.org/Rating Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Rating extends Intangible
{
    /**
     * @type float $bestRating The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $bestRating;
    /**
     * @type string $ratingValue The rating for the content.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $ratingValue;
    /**
     * @type float $worstRating The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $worstRating;
}
