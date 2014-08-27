<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * A list of possible conditions for the item.
 * 
 * @see http://schema.org/OfferItemCondition Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OfferItemCondition extends Enum
{
    /**
     * @type string DAMAGED_CONDITION Indicates that the item is damaged.
    */
    const DAMAGED_CONDITION = 'http://schema.org/DamagedCondition';
    /**
     * @type string NEW_CONDITION Indicates that the item is new.
    */
    const NEW_CONDITION = 'http://schema.org/NewCondition';
    /**
     * @type string REFURBISHED_CONDITION Indicates that the item is refurbished.
    */
    const REFURBISHED_CONDITION = 'http://schema.org/RefurbishedCondition';
    /**
     * @type string USED_CONDITION Indicates that the item is used.
    */
    const USED_CONDITION = 'http://schema.org/UsedCondition';
}
