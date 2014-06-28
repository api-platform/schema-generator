<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Educational Organization
 * 
 * @link http://schema.org/EducationalOrganization
 * 
 * @ORM\MappedSuperclass
 */
class EducationalOrganization extends Organization
{
    /**
     * Alumni
     * 
     * @var Person $alumni Alumni of educational organization.
     * 
     */
    private $alumni;
}
