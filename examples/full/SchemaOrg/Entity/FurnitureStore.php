<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A furniture store.
 * 
 * @see http://schema.org/FurnitureStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FurnitureStore extends Store
{
}
