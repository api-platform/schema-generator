<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A tennis complex.
 * 
 * @see http://schema.org/TennisComplex Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TennisComplex extends SportsActivityLocation
{
}
