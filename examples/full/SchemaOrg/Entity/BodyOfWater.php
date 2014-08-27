<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A body of water, such as a sea, ocean, or lake.
 * 
 * @see http://schema.org/BodyOfWater Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BodyOfWater extends Landform
{
}
