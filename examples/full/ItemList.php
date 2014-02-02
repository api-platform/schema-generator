<?php

namespace SchemaOrg;

/**
 * Item List
 *
 * @link http://schema.org/ItemList
 */
class ItemList extends CreativeWork
{
    /**
     * Item List Element
     *
     * @var string A single list item.
     */
    protected $itemListElement;
    /**
     * Item List Order
     *
     * @var string Type of ordering (e.g. Ascending, Descending, Unordered).
     */
    protected $itemListOrder;
}
