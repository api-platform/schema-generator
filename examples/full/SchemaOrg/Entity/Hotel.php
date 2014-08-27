<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A hotel.
 * 
 * @see http://schema.org/Hotel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Hotel extends LodgingBusiness
{
}
