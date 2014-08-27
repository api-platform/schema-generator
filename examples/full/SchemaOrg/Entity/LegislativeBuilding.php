<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A legislative building&#x2014;for example, the state capitol.
 * 
 * @see http://schema.org/LegislativeBuilding Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LegislativeBuilding extends GovernmentBuilding
{
}
