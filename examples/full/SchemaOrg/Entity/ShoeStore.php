<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A shoe store.
 * 
 * @see http://schema.org/ShoeStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ShoeStore extends Store
{
}
