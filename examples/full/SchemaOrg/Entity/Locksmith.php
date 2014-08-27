<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A locksmith.
 * 
 * @see http://schema.org/Locksmith Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Locksmith extends HomeAndConstructionBusiness
{
}
