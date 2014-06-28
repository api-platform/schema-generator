<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lodging Business
 * 
 * @link http://schema.org/LodgingBusiness
 * 
 * @ORM\MappedSuperclass
 */
class LodgingBusiness extends LocalBusiness
{
}
