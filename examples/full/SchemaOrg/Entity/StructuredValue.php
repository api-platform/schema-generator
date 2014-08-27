<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Structured values are strings&#x2014;for example, addresses&#x2014;that have certain constraints on their structure.
 * 
 * @see http://schema.org/StructuredValue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class StructuredValue extends Intangible
{
}
