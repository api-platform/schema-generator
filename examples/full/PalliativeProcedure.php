<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Palliative Procedure
 * 
 * @link http://schema.org/PalliativeProcedure
 * 
 * @ORM\Entity
 */
class PalliativeProcedure extends MedicalProcedure
{
}
