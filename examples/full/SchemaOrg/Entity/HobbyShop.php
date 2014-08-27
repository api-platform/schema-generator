<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A store that sells materials useful or necessary for various hobbies.
 * 
 * @see http://schema.org/HobbyShop Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HobbyShop extends Store
{
}
