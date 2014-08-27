<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A hair salon.
 * 
 * @see http://schema.org/HairSalon Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HairSalon extends HealthAndBeautyBusiness
{
}
