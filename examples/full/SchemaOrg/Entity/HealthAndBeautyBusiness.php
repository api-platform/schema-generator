<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Health and beauty.
 * 
 * @see http://schema.org/HealthAndBeautyBusiness Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HealthAndBeautyBusiness extends LocalBusiness
{
}
