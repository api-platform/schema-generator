<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * High School
 * 
 * @link http://schema.org/HighSchool
 * 
 * @ORM\Entity
 */
class HighSchool extends EducationalOrganization
{
}
