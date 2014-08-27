<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A process of care using radiation aimed at improving a health condition.
 * 
 * @see http://schema.org/RadiationTherapy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RadiationTherapy extends MedicalTherapy
{
}
