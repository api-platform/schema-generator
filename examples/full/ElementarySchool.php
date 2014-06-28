<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Elementary School
 * 
 * @link http://schema.org/ElementarySchool
 * 
 * @ORM\Entity
 */
class ElementarySchool extends EducationalOrganization
{
}
