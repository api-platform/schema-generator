<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categories that represent an assessment of the risk of fetal injury due to a drug or pharmaceutical used as directed by the mother during pregnancy.
 * 
 * @see http://schema.org/DrugPregnancyCategory Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrugPregnancyCategory extends MedicalEnumeration
{
}
