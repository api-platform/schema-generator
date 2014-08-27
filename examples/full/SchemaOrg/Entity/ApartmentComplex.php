<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Residence type: Apartment complex.
 * 
 * @see http://schema.org/ApartmentComplex Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ApartmentComplex extends Residence
{
}
