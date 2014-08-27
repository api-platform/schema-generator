<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A painting.
 * 
 * @see http://schema.org/Painting Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Painting extends CreativeWork
{
}
