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
     * @type ProductModel $isVariantOf A pointer to a base product from which this product is a variant. It is safe to infer that the variant inherits all product features from the base model, unless defined locally. This is not transitive.
     * @ORM\OneToOne(targetEntity="ProductModel")
     */
    private $isVariantOf;
    /**
     * @type ProductModel $predecessorOf A pointer from a previous, often discontinued variant of the product to its newer variant.
     * @ORM\ManyToOne(targetEntity="ProductModel")
     */
    private $predecessorOf;
    /**
     * @type ProductModel $successorOf A pointer from a newer variant of a product  to its previous, often discontinued predecessor.
     * @ORM\ManyToOne(targetEntity="ProductModel")
     */
    private $successorOf;
}
