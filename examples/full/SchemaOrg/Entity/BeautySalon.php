<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Beauty salon.
 * 
 * @see http://schema.org/BeautySalon Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BeautySalon extends HealthAndBeautyBusiness
{
}
