<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A home goods store.
 * 
 * @see http://schema.org/HomeGoodsStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HomeGoodsStore extends Store
{
}
