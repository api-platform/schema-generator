<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Emergency Service
 * 
 * @link http://schema.org/EmergencyService
 * 
 * @ORM\MappedSuperclass
 */
class EmergencyService extends LocalBusiness
{
}
