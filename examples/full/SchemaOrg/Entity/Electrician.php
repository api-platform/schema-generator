<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An electrician.
 * 
 * @see http://schema.org/Electrician Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Electrician extends HomeAndConstructionBusiness
{
}
