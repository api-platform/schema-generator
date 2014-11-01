<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A utility class that serves as the umbrella for a number of 'intangible' things in the medical space.
 * 
 * @see http://schema.org/MedicalIntangible Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalIntangible extends MedicalEntity
{
}
