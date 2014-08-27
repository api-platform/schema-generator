<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Quantities such as distance, time, mass, weight, etc. Particular instances of say Mass are entities like '3 Kg' or '4 milligrams'.
 * 
 * @see http://schema.org/Quantity Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Quantity extends Intangible
{
}
