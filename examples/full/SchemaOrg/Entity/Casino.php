<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A casino.
 * 
 * @see http://schema.org/Casino Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Casino extends EntertainmentBusiness
{
}
