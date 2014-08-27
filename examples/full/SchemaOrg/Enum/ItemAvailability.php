<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * A list of possible product availability options.
 * 
 * @see http://schema.org/ItemAvailability Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ItemAvailability extends Enum
{
    /**
     * @type string DISCONTINUED Indicates that the item has been discontinued.
    */
    const DISCONTINUED = 'http://schema.org/Discontinued';
    /**
     * @type string IN_STOCK Indicates that the item is in stock.
    */
    const IN_STOCK = 'http://schema.org/InStock';
    /**
     * @type string IN_STORE_ONLY Indicates that the item is available only at physical locations.
    */
    const IN_STORE_ONLY = 'http://schema.org/InStoreOnly';
    /**
     * @type string LIMITED_AVAILABILITY Indicates that the item has limited availability.
    */
    const LIMITED_AVAILABILITY = 'http://schema.org/LimitedAvailability';
    /**
     * @type string ONLINE_ONLY Indicates that the item is available only online.
    */
    const ONLINE_ONLY = 'http://schema.org/OnlineOnly';
    /**
     * @type string OUT_OF_STOCK Indicates that the item is out of stock.
    */
    const OUT_OF_STOCK = 'http://schema.org/OutOfStock';
    /**
     * @type string PRE_ORDER Indicates that the item is available for pre-order.
    */
    const PRE_ORDER = 'http://schema.org/PreOrder';
    /**
     * @type string SOLD_OUT Indicates that the item has sold out.
    */
    const SOLD_OUT = 'http://schema.org/SoldOut';
}
