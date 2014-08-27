<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A vet's office.
 * 
 * @see http://schema.org/VeterinaryCare Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class VeterinaryCare extends MedicalOrganization
{
}
