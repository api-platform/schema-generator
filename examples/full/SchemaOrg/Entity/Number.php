<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data type: Number.
 * 
 * @see http://schema.org/Number Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Number extends DataType
{
}
