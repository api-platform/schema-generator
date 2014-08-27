<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A graveyard.
 * 
 * @see http://schema.org/Cemetery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Cemetery extends CivicStructure
{
}
