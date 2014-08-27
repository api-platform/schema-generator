<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data type: Floating number.
 * 
 * @see http://schema.org/Float Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Float extends Number
{
}
