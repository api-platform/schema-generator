<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug Cost Category
 * 
 * @link http://schema.org/DrugCostCategory
 * 
 * @ORM\Entity
 */
class DrugCostCategory extends MedicalEnumeration
{
}
