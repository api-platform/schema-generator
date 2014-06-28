<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Study Status
 * 
 * @link http://schema.org/MedicalStudyStatus
 * 
 * @ORM\Entity
 */
class MedicalStudyStatus extends MedicalEnumeration
{
}
