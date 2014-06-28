<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Quantity
 * 
 * @link http://schema.org/Quantity
 * 
 * @ORM\MappedSuperclass
 */
class Quantity extends Intangible
{
}
