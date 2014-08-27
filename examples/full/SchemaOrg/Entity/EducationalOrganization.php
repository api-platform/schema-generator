<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An educational organization.
 * 
 * @see http://schema.org/EducationalOrganization Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EducationalOrganization extends Organization
{
    /**
     * @type Person $alumni Alumni of educational organization.
     */
    private $alumni;
}
