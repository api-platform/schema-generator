<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A government building.
 * 
 * @see http://schema.org/GovernmentBuilding Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GovernmentBuilding extends CivicStructure
{
}
