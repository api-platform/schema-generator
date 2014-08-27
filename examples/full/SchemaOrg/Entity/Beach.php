<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Beach.
 * 
 * @see http://schema.org/Beach Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Beach extends CivicStructure
{
}
