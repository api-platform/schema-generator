<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A lake (for example, Lake Pontrachain).
 * 
 * @see http://schema.org/LakeBodyOfWater Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LakeBodyOfWater extends BodyOfWater
{
}
