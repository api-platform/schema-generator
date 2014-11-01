<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A datasheet or vendor specification of a product (in the sense of a prototypical description).
 * 
 * @see http://schema.org/ProductModel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ProductModel extends Product
{
    /**
     */
    private $isVariantOf;
    /**
     */
    private $predecessorOf;
    /**
     */
    private $successorOf;
}
