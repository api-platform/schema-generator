<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A nightclub or discotheque.
 * 
 * @see http://schema.org/NightClub Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class NightClub extends EntertainmentBusiness
{
}
