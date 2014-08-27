<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A men's clothing store.
 * 
 * @see http://schema.org/MensClothingStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MensClothingStore extends Store
{
}
