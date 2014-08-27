<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A campground.
 * 
 * @see http://schema.org/Campground Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Campground extends CivicStructure
{
}
