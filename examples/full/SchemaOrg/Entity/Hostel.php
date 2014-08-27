<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A hostel - cheap accommodation, often in shared dormitories.
 * 
 * @see http://schema.org/Hostel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Hostel extends LodgingBusiness
{
}
