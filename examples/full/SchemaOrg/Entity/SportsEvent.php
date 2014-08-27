<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Sports event.
 * 
 * @see http://schema.org/SportsEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SportsEvent extends Event
{
}
