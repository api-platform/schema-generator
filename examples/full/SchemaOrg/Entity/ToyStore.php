<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A toy store.
 * 
 * @see http://schema.org/ToyStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ToyStore extends Store
{
}
