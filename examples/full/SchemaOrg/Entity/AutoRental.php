<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A car rental business.
 * 
 * @see http://schema.org/AutoRental Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutoRental extends AutomotiveBusiness
{
}
