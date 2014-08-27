<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A motel.
 * 
 * @see http://schema.org/Motel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Motel extends LodgingBusiness
{
}
