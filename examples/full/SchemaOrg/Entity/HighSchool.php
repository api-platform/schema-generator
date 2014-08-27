<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A high school.
 * 
 * @see http://schema.org/HighSchool Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HighSchool extends EducationalOrganization
{
}
