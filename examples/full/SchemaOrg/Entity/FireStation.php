<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A fire station. With firemen.
 * 
 * @see http://schema.org/FireStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FireStation extends CivicStructure
{
}
