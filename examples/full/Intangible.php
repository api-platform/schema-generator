<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Intangible
 * 
 * @link http://schema.org/Intangible
 * 
 * @ORM\MappedSuperclass
 */
class Intangible extends Thing
{
}
