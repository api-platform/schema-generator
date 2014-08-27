<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A canal, like the Panama Canal
 * 
 * @see http://schema.org/Canal Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Canal extends BodyOfWater
{
}
