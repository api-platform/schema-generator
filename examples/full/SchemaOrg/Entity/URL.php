<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data type: URL.
 * 
 * @see http://schema.org/URL Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class URL extends Text
{
}
