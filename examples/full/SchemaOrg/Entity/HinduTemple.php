<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Hindu temple.
 * 
 * @see http://schema.org/HinduTemple Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HinduTemple extends PlaceOfWorship
{
}
