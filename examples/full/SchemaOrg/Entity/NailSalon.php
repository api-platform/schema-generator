<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A nail salon.
 * 
 * @see http://schema.org/NailSalon Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class NailSalon extends HealthAndBeautyBusiness
{
}
