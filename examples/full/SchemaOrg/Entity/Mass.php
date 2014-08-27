<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Properties that take Mass as values are of the form '&lt;Number&gt; &lt;Mass unit of measure&gt;'. E.g., '7 kg'
 * 
 * @see http://schema.org/Mass Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Mass extends Quantity
{
}
