<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User Likes
 * 
 * @link http://schema.org/UserLikes
 * 
 * @ORM\Entity
 */
class UserLikes extends UserInteraction
{
}
