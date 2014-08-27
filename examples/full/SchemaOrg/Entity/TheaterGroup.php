<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A theater group or company, for example, the Royal Shakespeare Company or Druid Theatre.
 * 
 * @see http://schema.org/TheaterGroup Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TheaterGroup extends PerformingGroup
{
}
