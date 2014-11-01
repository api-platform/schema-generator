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
     */
    private $bestRating;
    /**
     */
    private $ratingValue;
    /**
     */
    private $worstRating;
}
