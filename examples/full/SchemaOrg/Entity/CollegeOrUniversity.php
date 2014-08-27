<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A college, university, or other third-level educational institution.
 * 
 * @see http://schema.org/CollegeOrUniversity Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CollegeOrUniversity extends EducationalOrganization
{
}
