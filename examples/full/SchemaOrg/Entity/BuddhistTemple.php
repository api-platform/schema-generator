<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Buddhist temple.
 * 
 * @see http://schema.org/BuddhistTemple Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BuddhistTemple extends PlaceOfWorship
{
}
