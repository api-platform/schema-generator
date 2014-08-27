<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A sports club.
 * 
 * @see http://schema.org/SportsClub Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SportsClub extends SportsActivityLocation
{
}
