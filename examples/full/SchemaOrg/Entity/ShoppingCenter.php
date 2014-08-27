<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A shopping center or mall.
 * 
 * @see http://schema.org/ShoppingCenter Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ShoppingCenter extends LocalBusiness
{
}
