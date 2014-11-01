<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Music event.
 * 
 * @see http://schema.org/MusicEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicEvent extends Event
{
}
