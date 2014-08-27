<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A river (for example, the broad majestic Shannon).
 * 
 * @see http://schema.org/RiverBodyOfWater Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RiverBodyOfWater extends BodyOfWater
{
}
