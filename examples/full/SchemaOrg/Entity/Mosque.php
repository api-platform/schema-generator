<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A mosque.
 * 
 * @see http://schema.org/Mosque Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Mosque extends PlaceOfWorship
{
}
