<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A bowling alley.
 * 
 * @see http://schema.org/BowlingAlley Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BowlingAlley extends SportsActivityLocation
{
}
