<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A general contractor.
 * 
 * @see http://schema.org/GeneralContractor Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GeneralContractor extends HomeAndConstructionBusiness
{
}
