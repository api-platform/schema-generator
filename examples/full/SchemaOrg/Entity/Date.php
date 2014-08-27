<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A date value in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>.
 * 
 * @see http://schema.org/Date Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Date extends DataType
{
}
