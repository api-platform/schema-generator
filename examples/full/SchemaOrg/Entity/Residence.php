<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The place where a person lives.
 * 
 * @see http://schema.org/Residence Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Residence extends Place
{
}
