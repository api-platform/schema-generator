<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A gas station.
 * 
 * @see http://schema.org/GasStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GasStation extends AutomotiveBusiness
{
}
