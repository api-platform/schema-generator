<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A clothing store.
 * 
 * @see http://schema.org/ClothingStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ClothingStore extends Store
{
}
