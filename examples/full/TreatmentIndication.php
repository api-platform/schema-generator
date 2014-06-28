<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Treatment Indication
 * 
 * @link http://schema.org/TreatmentIndication
 * 
 * @ORM\Entity
 */
class TreatmentIndication extends MedicalIndication
{
}
