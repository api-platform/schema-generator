<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical procedure intended primarily for therapeutic purposes, aimed at improving a health condition.
 * 
 * @see http://schema.org/TherapeuticProcedure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TherapeuticProcedure extends MedicalProcedure
{
}
