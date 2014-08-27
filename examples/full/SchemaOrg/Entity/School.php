<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A school.
 * 
 * @see http://schema.org/School Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class School extends EducationalOrganization
{
}
