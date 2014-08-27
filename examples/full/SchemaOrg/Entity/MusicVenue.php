<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A music venue.
 * 
 * @see http://schema.org/MusicVenue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicVenue extends CivicStructure
{
}
