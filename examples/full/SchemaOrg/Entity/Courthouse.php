<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A courthouse.
 * 
 * @see http://schema.org/Courthouse Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Courthouse extends GovernmentBuilding
{
}
