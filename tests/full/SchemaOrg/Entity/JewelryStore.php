<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A jewelry store.
 * 
 * @see http://schema.org/JewelryStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class JewelryStore extends Store
{
}
