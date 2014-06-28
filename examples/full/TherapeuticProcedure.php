<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Therapeutic Procedure
 * 
 * @link http://schema.org/TherapeuticProcedure
 * 
 * @ORM\Entity
 */
class TherapeuticProcedure extends MedicalProcedure
{
}
