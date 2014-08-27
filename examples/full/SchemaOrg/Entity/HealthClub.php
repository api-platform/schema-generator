<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A health club.
 * 
 * @see http://schema.org/HealthClub Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HealthClub extends HealthAndBeautyBusiness
{
}
