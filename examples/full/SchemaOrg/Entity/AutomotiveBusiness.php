<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Car repair, sales, or parts.
 * 
 * @see http://schema.org/AutomotiveBusiness Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutomotiveBusiness extends LocalBusiness
{
}
