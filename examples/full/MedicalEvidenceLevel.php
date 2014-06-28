<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Evidence Level
 * 
 * @link http://schema.org/MedicalEvidenceLevel
 * 
 * @ORM\Entity
 */
class MedicalEvidenceLevel extends MedicalEnumeration
{
}
