<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A class, also often called a 'Type'; equivalent to rdfs:Class.
 * 
 * @see http://schema.org/Class Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Class extends Intangible
{
}
