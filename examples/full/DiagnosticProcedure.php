<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Diagnostic Procedure
 * 
 * @link http://schema.org/DiagnosticProcedure
 * 
 * @ORM\Entity
 */
class DiagnosticProcedure extends MedicalProcedure
{
}
