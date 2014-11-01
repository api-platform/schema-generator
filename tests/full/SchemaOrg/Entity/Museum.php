<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A museum.
 * 
 * @see http://schema.org/Museum Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Museum extends CivicStructure
{
}
