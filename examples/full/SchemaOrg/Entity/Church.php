<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A church.
 * 
 * @see http://schema.org/Church Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Church extends PlaceOfWorship
{
}
