<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A playground.
 * 
 * @see http://schema.org/Playground Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Playground extends CivicStructure
{
}
