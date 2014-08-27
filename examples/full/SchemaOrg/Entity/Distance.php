<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Properties that take Distances as values are of the form '&lt;Number&gt; &lt;Length unit of measure&gt;'. E.g., '7 ft'
 * 
 * @see http://schema.org/Distance Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Distance extends Quantity
{
}
