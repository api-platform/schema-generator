<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A ski resort.
 * 
 * @see http://schema.org/SkiResort Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SkiResort extends SportsActivityLocation
{
}
