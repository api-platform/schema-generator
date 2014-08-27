<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A taxi stand.
 * 
 * @see http://schema.org/TaxiStand Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TaxiStand extends CivicStructure
{
}
