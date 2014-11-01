<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A middle school (typically for children aged around 11-14, although this varies somewhat).
 * 
 * @see http://schema.org/MiddleSchool Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MiddleSchool extends EducationalOrganization
{
}
