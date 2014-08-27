<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Boolean: True or False.
 * 
 * @see http://schema.org/Boolean Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Boolean extends DataType
{
}
