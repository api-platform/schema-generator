<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An ocean (for example, the Pacific).
 * 
 * @see http://schema.org/OceanBodyOfWater Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OceanBodyOfWater extends BodyOfWater
{
}
