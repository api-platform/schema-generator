<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Residence
 * 
 * @link http://schema.org/Residence
 * 
 * @ORM\MappedSuperclass
 */
class Residence extends Place
{
}
