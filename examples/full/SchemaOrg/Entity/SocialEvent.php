<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Social event.
 * 
 * @see http://schema.org/SocialEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SocialEvent extends Event
{
}
