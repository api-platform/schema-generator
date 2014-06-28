<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Procedure Type
 * 
 * @link http://schema.org/MedicalProcedureType
 * 
 * @ORM\Entity
 */
class MedicalProcedureType extends MedicalEnumeration
{
}
