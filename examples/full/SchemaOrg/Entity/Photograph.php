<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A photograph.
 * 
 * @see http://schema.org/Photograph Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Photograph extends CreativeWork
{
}
