<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An amusement park.
 * 
 * @see http://schema.org/AmusementPark Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AmusementPark extends EntertainmentBusiness
{
}
