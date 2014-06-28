<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Enumeration
 * 
 * @link http://schema.org/Enumeration
 * 
 * @ORM\MappedSuperclass
 */
class Enumeration extends Intangible
{
}
