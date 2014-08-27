<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A motorcycle dealer.
 * 
 * @see http://schema.org/MotorcycleDealer Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MotorcycleDealer extends AutomotiveBusiness
{
}
