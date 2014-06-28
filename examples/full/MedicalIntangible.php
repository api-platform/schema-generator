<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Intangible
 * 
 * @link http://schema.org/MedicalIntangible
 * 
 * @ORM\MappedSuperclass
 */
class MedicalIntangible extends MedicalEntity
{
}
