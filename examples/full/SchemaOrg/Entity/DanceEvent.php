<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: A social dance.
 * 
 * @see http://schema.org/DanceEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DanceEvent extends Event
{
}
