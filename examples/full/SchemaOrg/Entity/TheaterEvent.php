<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Theater performance.
 * 
 * @see http://schema.org/TheaterEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TheaterEvent extends Event
{
}
