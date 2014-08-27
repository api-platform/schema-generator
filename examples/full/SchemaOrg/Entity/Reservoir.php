<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A reservoir of water, typically an artificially created lake, like the Lake Kariba reservoir.
 * 
 * @see http://schema.org/Reservoir Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Reservoir extends BodyOfWater
{
}
