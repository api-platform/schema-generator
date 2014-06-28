<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Home And Construction Business
 * 
 * @link http://schema.org/HomeAndConstructionBusiness
 * 
 * @ORM\MappedSuperclass
 */
class HomeAndConstructionBusiness extends LocalBusiness
{
}
