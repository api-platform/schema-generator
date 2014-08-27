<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An automobile.
 * 
 * @see http://schema.org/Car Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Car extends Vehicle
{
}
