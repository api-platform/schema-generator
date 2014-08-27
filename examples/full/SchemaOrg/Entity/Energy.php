<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Properties that take Energy as values are of the form '&lt;Number&gt; &lt;Energy unit of measure&gt;'
 * 
 * @see http://schema.org/Energy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Energy extends Quantity
{
}
