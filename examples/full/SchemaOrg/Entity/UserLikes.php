<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: Like an item.
 * 
 * @see http://schema.org/UserLikes Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserLikes extends UserInteraction
{
}
