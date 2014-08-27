<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A movie theater.
 * 
 * @see http://schema.org/MovieTheater Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MovieTheater extends CivicStructure
{
}
