<?php


namespace SchemaOrg\Enum;


/**
 * Enumerated for values for itemListOrder for indicating how an ordered ItemList is organized.
 * 
 * @see http://schema.org/ItemListOrderType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ItemListOrderType extends Enum
{
    /**
     * @type string ITEM_LIST_ORDER_ASCENDING An ItemList ordered with lower values listed first.
    */
    const ITEM_LIST_ORDER_ASCENDING = 'http://schema.org/ItemListOrderAscending';
    /**
     * @type string ITEM_LIST_ORDER_DESCENDING An ItemList ordered with higher values listed first.
    */
    const ITEM_LIST_ORDER_DESCENDING = 'http://schema.org/ItemListOrderDescending';
    /**
     * @type string ITEM_LIST_UNORDERED An ItemList ordered with no explicit order.
    */
    const ITEM_LIST_UNORDERED = 'http://schema.org/ItemListUnordered';
}
