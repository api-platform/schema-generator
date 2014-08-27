<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The basic data types such as Integers, Strings, etc.
 * 
 * @see http://schema.org/DataType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DataType
{
}
