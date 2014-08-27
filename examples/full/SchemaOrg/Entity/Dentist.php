<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A dentist.
 * 
 * @see http://schema.org/Dentist Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Dentist extends MedicalOrganization
{
}
