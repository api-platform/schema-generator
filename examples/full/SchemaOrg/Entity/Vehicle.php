<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A vehicle.
 * 
 * @see http://schema.org/Vehicle Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Vehicle extends Product
{
}
