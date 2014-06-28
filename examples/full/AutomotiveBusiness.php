<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Automotive Business
 * 
 * @link http://schema.org/AutomotiveBusiness
 * 
 * @ORM\MappedSuperclass
 */
class AutomotiveBusiness extends LocalBusiness
{
}
