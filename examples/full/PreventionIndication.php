<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Prevention Indication
 * 
 * @link http://schema.org/PreventionIndication
 * 
 * @ORM\Entity
 */
class PreventionIndication extends MedicalIndication
{
}
