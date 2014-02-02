<?php

namespace SchemaOrg;

/**
 * Product Model
 *
 * @link http://schema.org/ProductModel
 */
class ProductModel extends Product
{
    /**
     * Is Variant of
     *
     * @var ProductModel A pointer to a base product from which this product is a variant. It is safe to infer that the variant inherits all product features from the base model, unless defined locally. This is not transitive.
     */
    protected $isVariantOf;
    /**
     * Predecessor of
     *
     * @var ProductModel A pointer from a previous, often discontinued variant of the product to its newer variant.
     */
    protected $predecessorOf;
    /**
     * Successor of
     *
     * @var ProductModel A pointer from a newer variant of a product  to its previous, often discontinued predecessor.
     */
    protected $successorOf;
}
