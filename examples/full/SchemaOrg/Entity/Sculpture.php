<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A piece of sculpture.
 * 
 * @see http://schema.org/Sculpture Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Sculpture extends CreativeWork
{
}
