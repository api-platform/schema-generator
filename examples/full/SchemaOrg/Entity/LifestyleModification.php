<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A process of care involving exercise, changes to diet, fitness routines, and other lifestyle changes aimed at improving a health condition.
 * 
 * @see http://schema.org/LifestyleModification Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LifestyleModification extends MedicalTherapy
{
}
