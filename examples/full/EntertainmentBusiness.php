<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entertainment Business
 * 
 * @link http://schema.org/EntertainmentBusiness
 * 
 * @ORM\MappedSuperclass
 */
class EntertainmentBusiness extends LocalBusiness
{
}
