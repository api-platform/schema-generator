<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A park.
 * 
 * @see http://schema.org/Park Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Park extends CivicStructure
{
}
