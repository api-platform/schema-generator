<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Enumerated categories of medical drug costs.
 * 
 * @see http://schema.org/DrugCostCategory Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrugCostCategory extends MedicalEnumeration
{
}
