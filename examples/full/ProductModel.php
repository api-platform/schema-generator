<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product Model
 * 
 * @link http://schema.org/ProductModel
 * 
 * @ORM\Entity
 */
class ProductModel extends Product
{
    /**
     * Is Variant of
     * 
     * @var ProductModel $isVariantOf A pointer to a base product from which this product is a variant. It is safe to infer that the variant inherits all product features from the base model, unless defined locally. This is not transitive.
     * 
     * @ORM\OneToOne(targetEntity="ProductModel")
     */
    private $isVariantOf;
    /**
     * Predecessor of
     * 
     * @var ProductModel $predecessorOf A pointer from a previous, often discontinued variant of the product to its newer variant.
     * 
     * @ORM\ManyToOne(targetEntity="ProductModel")
     */
    private $predecessorOf;
    /**
     * Successor of
     * 
     * @var ProductModel $successorOf A pointer from a newer variant of a product  to its previous, often discontinued predecessor.
     * 
     * @ORM\ManyToOne(targetEntity="ProductModel")
     */
    private $successorOf;
}
