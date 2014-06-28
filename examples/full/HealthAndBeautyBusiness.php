<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Health And Beauty Business
 * 
 * @link http://schema.org/HealthAndBeautyBusiness
 * 
 * @ORM\MappedSuperclass
 */
class HealthAndBeautyBusiness extends LocalBusiness
{
}
