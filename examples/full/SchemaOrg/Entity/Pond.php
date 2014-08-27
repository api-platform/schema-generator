<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A pond
 * 
 * @see http://schema.org/Pond Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Pond extends BodyOfWater
{
}
