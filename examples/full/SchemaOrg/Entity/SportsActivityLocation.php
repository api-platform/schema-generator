<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A sports location, such as a playing field.
 * 
 * @see http://schema.org/SportsActivityLocation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SportsActivityLocation extends LocalBusiness
{
}
