<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * School
 * 
 * @link http://schema.org/School
 * 
 * @ORM\Entity
 */
class School extends EducationalOrganization
{
}
