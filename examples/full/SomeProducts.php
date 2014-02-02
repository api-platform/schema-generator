<?php

namespace SchemaOrg;

/**
 * Some Products
 *
 * @link http://schema.org/SomeProducts
 */
class SomeProducts extends Product
{
    /**
     * Inventory Level
     *
     * @var QuantitativeValue The current approximate inventory level for the item or items.
     */
    protected $inventoryLevel;
}
