<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * College or University
 * 
 * @link http://schema.org/CollegeOrUniversity
 * 
 * @ORM\Entity
 */
class CollegeOrUniversity extends EducationalOrganization
{
}
