<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A waterfall, like Niagara
 * 
 * @see http://schema.org/Waterfall Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Waterfall extends BodyOfWater
{
}
