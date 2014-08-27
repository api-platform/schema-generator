<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A motorcycle repair shop.
 * 
 * @see http://schema.org/MotorcycleRepair Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MotorcycleRepair extends AutomotiveBusiness
{
}
