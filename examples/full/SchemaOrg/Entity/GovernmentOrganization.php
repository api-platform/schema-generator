<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A governmental organization or agency.
 * 
 * @see http://schema.org/GovernmentOrganization Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GovernmentOrganization extends Organization
{
}
