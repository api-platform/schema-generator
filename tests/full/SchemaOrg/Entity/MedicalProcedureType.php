<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An enumeration that describes different types of medical procedures.
 * 
 * @see http://schema.org/MedicalProcedureType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalProcedureType extends MedicalEnumeration
{
}
