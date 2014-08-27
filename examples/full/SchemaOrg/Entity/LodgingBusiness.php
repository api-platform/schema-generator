<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A lodging business, such as a motel, hotel, or inn.
 * 
 * @see http://schema.org/LodgingBusiness Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LodgingBusiness extends LocalBusiness
{
}
