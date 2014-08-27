<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Catholic church.
 * 
 * @see http://schema.org/CatholicChurch Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CatholicChurch extends PlaceOfWorship
{
}
