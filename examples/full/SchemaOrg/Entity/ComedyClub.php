<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A comedy club.
 * 
 * @see http://schema.org/ComedyClub Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ComedyClub extends EntertainmentBusiness
{
}
