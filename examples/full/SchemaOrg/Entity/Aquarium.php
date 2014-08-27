<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Aquarium.
 * 
 * @see http://schema.org/Aquarium Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Aquarium extends CivicStructure
{
}
