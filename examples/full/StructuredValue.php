<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Structured Value
 * 
 * @link http://schema.org/StructuredValue
 * 
 * @ORM\MappedSuperclass
 */
class StructuredValue extends Intangible
{
}
