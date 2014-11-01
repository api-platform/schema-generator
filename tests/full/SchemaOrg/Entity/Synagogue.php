<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A synagogue.
 * 
 * @see http://schema.org/Synagogue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Synagogue extends PlaceOfWorship
{
}
