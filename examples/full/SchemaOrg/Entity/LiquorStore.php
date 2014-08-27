<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A shop that sells alcoholic drinks such as wine, beer, whisky and other spirits.
 * 
 * @see http://schema.org/LiquorStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LiquorStore extends Store
{
}
