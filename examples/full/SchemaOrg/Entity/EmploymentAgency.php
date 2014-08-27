<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An employment agency.
 * 
 * @see http://schema.org/EmploymentAgency Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EmploymentAgency extends LocalBusiness
{
}
