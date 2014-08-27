<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A sporting goods store.
 * 
 * @see http://schema.org/SportingGoodsStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SportingGoodsStore extends Store
{
}
