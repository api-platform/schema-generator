<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A tire shop.
 * 
 * @see http://schema.org/TireShop Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TireShop extends Store
{
}
