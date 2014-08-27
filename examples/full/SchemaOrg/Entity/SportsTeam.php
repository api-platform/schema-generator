<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Organization: Sports team.
 * 
 * @see http://schema.org/SportsTeam Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SportsTeam extends Organization
{
}
