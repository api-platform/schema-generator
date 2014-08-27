<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A permit issued by a government agency.
 * 
 * @see http://schema.org/GovernmentPermit Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GovernmentPermit extends Permit
{
}
