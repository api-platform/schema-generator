<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A library.
 * 
 * @see http://schema.org/Library Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Library extends LocalBusiness
{
}
