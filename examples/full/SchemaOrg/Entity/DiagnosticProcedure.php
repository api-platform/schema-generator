<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical procedure intended primarily for diagnostic, as opposed to therapeutic, purposes.
 * 
 * @see http://schema.org/DiagnosticProcedure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DiagnosticProcedure extends MedicalProcedure
{
}
