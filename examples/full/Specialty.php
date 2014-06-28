<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Specialty
 * 
 * @link http://schema.org/Specialty
 * 
 * @ORM\MappedSuperclass
 */
class Specialty extends Enumeration
{
}
