<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A geographical region under the jurisdiction of a particular government.
 * 
 * @see http://schema.org/AdministrativeArea Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AdministrativeArea extends Place
{
}
