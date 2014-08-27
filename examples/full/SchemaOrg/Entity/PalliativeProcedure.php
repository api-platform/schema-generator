<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical procedure intended primarily for palliative purposes, aimed at relieving the symptoms of an underlying health condition.
 * 
 * @see http://schema.org/PalliativeProcedure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PalliativeProcedure extends MedicalProcedure
{
}
