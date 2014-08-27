<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A day spa.
 * 
 * @see http://schema.org/DaySpa Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DaySpa extends HealthAndBeautyBusiness
{
}
