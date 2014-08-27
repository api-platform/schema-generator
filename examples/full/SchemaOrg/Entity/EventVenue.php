<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An event venue.
 * 
 * @see http://schema.org/EventVenue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EventVenue extends CivicStructure
{
}
