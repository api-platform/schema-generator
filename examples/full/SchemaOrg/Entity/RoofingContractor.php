<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A roofing contractor.
 * 
 * @see http://schema.org/RoofingContractor Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RoofingContractor extends HomeAndConstructionBusiness
{
}
