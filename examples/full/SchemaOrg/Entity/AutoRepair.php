<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Car repair business.
 * 
 * @see http://schema.org/AutoRepair Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutoRepair extends AutomotiveBusiness
{
}
