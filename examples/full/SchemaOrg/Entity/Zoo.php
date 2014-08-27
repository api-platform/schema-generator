<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A zoo.
 * 
 * @see http://schema.org/Zoo Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Zoo extends CivicStructure
{
}
