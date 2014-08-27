<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: Play count of an item, for example a video or a song.
 * 
 * @see http://schema.org/UserPlays Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserPlays extends UserInteraction
{
}
