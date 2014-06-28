<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug Pregnancy Category
 * 
 * @link http://schema.org/DrugPregnancyCategory
 * 
 * @ORM\Entity
 */
class DrugPregnancyCategory extends MedicalEnumeration
{
}
