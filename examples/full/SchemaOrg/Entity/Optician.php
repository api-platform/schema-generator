<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A store that sells reading glasses and similar devices for improving vision.
 * 
 * @see http://schema.org/Optician Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Optician extends MedicalOrganization
{
}
