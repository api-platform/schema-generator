<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: Tweets.
 * 
 * @see http://schema.org/UserTweets Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserTweets extends UserInteraction
{
}
