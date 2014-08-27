<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A dance group&#x2014;for example, the Alvin Ailey Dance Theater or Riverdance.
 * 
 * @see http://schema.org/DanceGroup Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DanceGroup extends PerformingGroup
{
}
