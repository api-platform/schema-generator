<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A moving company.
 * 
 * @see http://schema.org/MovingCompany Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MovingCompany extends HomeAndConstructionBusiness
{
}
