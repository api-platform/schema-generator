<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Apartment Complex
 * 
 * @link http://schema.org/ApartmentComplex
 * 
 * @ORM\Entity
 */
class ApartmentComplex extends Residence
{
}
