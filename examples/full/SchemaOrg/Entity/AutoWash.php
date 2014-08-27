<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A car wash business.
 * 
 * @see http://schema.org/AutoWash Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutoWash extends AutomotiveBusiness
{
}
