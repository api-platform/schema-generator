<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A public swimming pool.
 * 
 * @see http://schema.org/PublicSwimmingPool Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PublicSwimmingPool extends SportsActivityLocation
{
}
