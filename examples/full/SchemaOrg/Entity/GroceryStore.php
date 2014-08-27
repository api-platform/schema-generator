<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A grocery store.
 * 
 * @see http://schema.org/GroceryStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GroceryStore extends Store
{
}
