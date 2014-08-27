<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A hardware store.
 * 
 * @see http://schema.org/HardwareStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HardwareStore extends Store
{
}
