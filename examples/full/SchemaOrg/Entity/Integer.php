<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data type: Integer.
 * 
 * @see http://schema.org/Integer Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Integer extends Number
{
}
