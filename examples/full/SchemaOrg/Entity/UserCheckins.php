<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: Check-in at a place.
 * 
 * @see http://schema.org/UserCheckins Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserCheckins extends UserInteraction
{
}
