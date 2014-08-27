<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A pet store.
 * 
 * @see http://schema.org/PetStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PetStore extends Store
{
}
