<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A subclass of Role used to describe roles within organizations.
 * 
 * @see http://schema.org/OrganizationRole Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OrganizationRole extends Role
{
    /**
     * @type string $namedPosition A position played, performed or filled by a person or organization, as part of an organization. For example, an athlete in a SportsTeam might play in the position named 'Quarterback'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $namedPosition;
}
