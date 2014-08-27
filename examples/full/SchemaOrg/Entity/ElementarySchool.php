<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An elementary school.
 * 
 * @see http://schema.org/ElementarySchool Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ElementarySchool extends EducationalOrganization
{
}
