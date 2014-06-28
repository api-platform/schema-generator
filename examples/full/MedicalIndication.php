<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Indication
 * 
 * @link http://schema.org/MedicalIndication
 * 
 * @ORM\MappedSuperclass
 */
class MedicalIndication extends MedicalEntity
{
}
