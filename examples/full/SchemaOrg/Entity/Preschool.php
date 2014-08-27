<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A preschool.
 * 
 * @see http://schema.org/Preschool Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Preschool extends EducationalOrganization
{
}
