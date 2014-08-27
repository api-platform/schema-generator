<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Animal shelter.
 * 
 * @see http://schema.org/AnimalShelter Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AnimalShelter extends LocalBusiness
{
}
