<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data type: Text.
 * 
 * @see http://schema.org/Text Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Text extends DataType
{
}
