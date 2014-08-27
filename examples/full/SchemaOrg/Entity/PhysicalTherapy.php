<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A process of progressive physical care and rehabilitation aimed at improving a health condition.
 * 
 * @see http://schema.org/PhysicalTherapy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PhysicalTherapy extends MedicalTherapy
{
}
