<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User Tweets
 * 
 * @link http://schema.org/UserTweets
 * 
 * @ORM\Entity
 */
class UserTweets extends UserInteraction
{
}
