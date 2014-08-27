<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A plumbing service.
 * 
 * @see http://schema.org/Plumber Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Plumber extends HomeAndConstructionBusiness
{
}
