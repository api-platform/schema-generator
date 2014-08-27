<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A sea (for example, the Caspian sea).
 * 
 * @see http://schema.org/SeaBodyOfWater Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SeaBodyOfWater extends BodyOfWater
{
}
